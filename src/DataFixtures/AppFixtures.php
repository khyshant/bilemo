<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setCustomername('customername');
        $customer->setEmail('test@test.fr');
        $customer->setFirstname('firstname');
        $customer->setLastname('lastname');
        $customer->setCompany('company');
        $customer->setPassword($this->userPasswordEncoder->encodePassword($customer, 'azerty123'));
        $manager->persist($customer);
        $manager->flush();
        for($i=1;$i<5;$i++) {
            $user= new User();
            $format = '%s-%d';
            $user->setLastname(sprintf('%s-%d', 'lastname_' , $i));
            $user->setFirstname(sprintf('%s-%d', 'fristname_' , $i));
            $user->setCustomer($customer);
            $manager->persist($user);
        }
        $category= new Category();
        $category->setName(sprintf('%s_%d','category',1));
        $category->setDescription(sprintf('%s_%d','description',1));
        $manager->persist($category);
        $manager->flush();
        $brand= new Brand();
        $brand->setName(sprintf('%s_%d','category',1));
        $brand->setDescription(sprintf('%s_%d','description',1));
        $manager->persist($brand);
        $manager->flush();
        $image= new Image();
        $image->setPath('image4.png');
        $manager->persist($image);
        $manager->flush();

        for($i=1;$i<5;$i++) {
            $user= new User();
            $format = '%s-%d';
            $user->setLastname(sprintf('%s%d', 'lastname_' , $i));
            $user->setFirstname(sprintf('%s%d', 'fristname_' , $i));
            $user->setCustomer($customer);
            $manager->persist($user);
            for($i=1;$i<5;$i++) {
                $product = new Product();
                $product->setBrand($brand);
                $product->setCategory($category);

                $product->setDescription(sprintf('%s_%d','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',$i));
                $product->setHeight(rand(1,120));
                $product->setName(sprintf('%s_%d','product',$i));
                $product->setPrice((rand(1,120)));
                $product->setWeight((rand(1,120)));
                $manager->persist($product);
            }
        }
        $manager->flush();
    }
}
