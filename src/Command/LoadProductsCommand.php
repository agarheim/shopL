<?php

namespace App\Command;

use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Repository\AttributeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Rct567\DomQuery\DomQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadProductsCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $temeDir;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parametrs)
    {
       parent::__construct();
       $this->entityManager = $entityManager;
       $this->temeDir = $parametrs->get('kernel.cache_dir').'images';
       if(!file_exists($this->temeDir)){
           mkdir($this->temeDir);
       }
    }

    protected static $defaultName = 'app:load-products';

    protected function configure()
    {
        $this
            ->setDescription('lad product for Comfy')
            ->addArgument('url', InputArgument::REQUIRED, 'URL for parsing products')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        $content = file_get_contents($url);

        $data = json_decode($content, true);

       /** @var ProductRepository $repo */
        $repo = $this->entityManager->getRepository(Product::class);

        foreach ($data as $item ){
            $io ->writeln($item['Name']);
            $product = $repo->findOneBy(['comfyId' => $item['ItemId']]);
            if(!$product){
                $product = new Product();
                $product->setComfyId($item['ItemId']);
                $this->entityManager->persist($product);

            }
               $product->setName($item['Name']);
               $product->setDescription($item['Description']);
               $product->setPrice($item['Price']*100);
               $this->processCategories($product, $item);
               $this->processAttributes($product, $item);

                if(isset($item['PictureUrl'])){
                    $image = $product->getImages()->first();
                    if (!$image){
                        $image = new ProductImage();

                        $product->addImage($image);

                        $imageContent = file_get_contents($item['PictureUrl']);
                        $imageFileName = basename($item['PictureUrl']);
                        $imagePath = $this->temeDir.'/'.$imageFileName;
                        file_put_contents($imagePath, $imageContent);

                        $uploadedImage = new UploadedFile(
                            $imagePath,
                            $imageFileName,
                            mime_content_type($imagePath),
                            null,
                            true
                        );
                        $image->setImage($uploadedImage);
                        $this->entityManager->persist($image);
                     }
                }

        }
        $this->entityManager->flush();
        $io->success('OK. COngratulation');
    }

    private function processCategories(Product $product, array $item)
    {
        $categoryRepo = $this->entityManager->getRepository(Category::class);
    foreach ($item['CategoryIds'] as $index => $categoryId){
        $category = $categoryRepo->findOneBy(['comfyId' => $categoryId]);
        if (!$category){
            $category = new Category();
            $this->entityManager->persist($category);
            $category->setName($item['CategoryNames'][$index]);
        }

        $product->addCategory($category);
      }
    }

    private function processAttributes(Product $product, array $item)
    {
        $content = file_get_contents($item['Url']);
        $dom = new DomQuery($content);

        /** @var AttributeRepository $attributeRepo */
        $attributeRepo = $this->entityManager->getRepository(Product::class);
        $attributeNodes = $dom->find('dl/features-item_list');
        $attributes = $this->getAllAttributes();

        /** @var DomQuery $node */
        foreach ($attributeNodes as $node){
            $title = $this->cleanupString($node->find('dt.title')->text());
            $value = $this->cleanupString($node->find('dd.value.value_item')->text());

            $attribute = $attributes[$title] ?? null;

            if (!$attribute){
                $attribute = new Attribute();
                $attribute->setName($title);
                $attribute->setCategory($product->getCategories()->first());
                $this->entityManager->persist($attribute);
                $attributes[$title] = $attribute;
            }
            $attributeValues = $attribute->getValuesList();

            if(!in_array($value, $attributeValues)){
                $attributeValues[] = $value;
                $attribute->setValuesList($attributeValues);

            }

            $productAttributeValue = $this->getProductAttributeValue($product, $attribute);
            $productAttributeValue->setValue($value);
        }
    }

    public function getAllAttributes()
    {
        $attributes = [];

        /** @var AttributeRepository $attributeRepo */
        $attributeRepo = $this->entityManager->getRepository(Attribute::class);

        foreach ($attributes->findAll() as $attribute){
            $attributes[$attribute->getName()] = $attribute;
        }

        return $attributes;
    }

    private function getProductAttributeValue($product, $attribute)
    {
        foreach ($product->getAttributeValues() as $productAttributeValue){
            if ($productAttributeValue->getAttribute() === $attribute){
                $attributeValue = $productAttributeValue;
            }
            }
            if(!$attributeValue){
                $attributeValue = new AttributeValue();
                $attributeValue->setAttribute($attribute);
                $this->entityManager->persist($attributeValue);
                $product->addAttributeValue($attributeValue);
            }
            return $attributeValue;
    }

    private function cleanupString($t)
    {
          $string = explode("\n", $t);
          list ($string) = array_values(array_filter(array_map('trim', $string)));

          return $string;
    }
}
