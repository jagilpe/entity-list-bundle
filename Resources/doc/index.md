Documentation
=============

This bundle was built with the main goal of make the building of list of entities easier and faster.

# Create a simple list

Suppose you want to build a list of user profiles. You'll have a "plain-old-PHP-object" that will represent your user
profile:

```php
<?php
// src/AppBundle/Entity/UserProfile.php
namespace AppBundle\Entity;

class UserProfile
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \DateTime
     */
    private $birthDate;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }
}
```

## Build the list

The simplest way to build an entity list from a controller is using an entity list builder.

In your controller, use the [Jagilpe\EntityListBundle\Controller\EntityListControllerTrait](https://api.gilpereda.com/entity-list-bundle/master/Jagilpe/EntityListBundle/Controller/EntityListControllerTrait.html)
and the you can get an entity builder using the method `createEntityListBuilder`. With this builder you can add the 
columns that the list will have.

```php
<?php

namespace AppBundle\Controller;

use Jagilpe\EntityListBundle\Controller\EntityListControllerTrait;
use Jagilpe\EntityListBundle\EntityList\ColumnType\SingleFieldColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\DateTimeColumnType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    use EntityListControllerTrait;

    public function userProfileListAction()
    {
        // Get the user profiles
        $profiles = $this->get('some_service')->getUserProfiles();
        
        // Get an entity list builder for the given profiles
        $listBuilder = $this->createEntityListBuilder($profiles);
        
        // Add the columns
        $listBuilder->add('firstName', SingleFieldColumnType::class, array('label' => 'First name'));
        $listBuilder->add('lastName', SingleFieldColumnType::class, array('label' => 'Last name'));
        $listBuilder->add('birthDate', DateTimeColumnType::class, array('label' => 'Last name'));
        
        // Get the list object
        $list = $listBuilder->getEntityList();
        
        // Return the page
        return $this->render('default/user_profile_list.html.twig', array('list' => $list,));
    }
}
```

## Render the list

To render the built list simply use the `jgp_list_render` twig function.

```twig
{# app/Resources/views/default/user_profile_list.html.twig #}
{{ jgp_list_render(list) }}
```

# Built-in column types

The standard types of columns that are defined in the bundle are:

* SingleFieldColumnType
* DateTimeColumnType
* CallbackColumnType

## SingleFieldColumnType

This is the simplest type of column. For a determined row it will rendered the given property in the correspondent cell.

For the following UserProfile entity class:
```php
<?php
// src/AppBundle/Entity/UserProfile.php
namespace AppBundle\Entity;

class UserProfile
{
    public $firstName;
    private $lastName;
    
    public function getLastName()
    {
        return $this->userProfile;
    }
    
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }
}

```

You could add the following columns to a user profiles list:

```php
<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Jagilpe\EntityListBundle\Controller\EntityListControllerTrait;
use Jagilpe\EntityListBundle\EntityList\ColumnType\SingleFieldColumnType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    use EntityListControllerTrait;
    
    public function userProfileListAction()
    {
        //...
        // Public property
        $listBuilder->add('firstName', SingleFieldColumnType::class);
        
        // Private property through a getter
        $listBuilder->add('lastName', SingleFieldColumnType::class);
       
        // Virtual property through a getter
        $listBuilder->add('fullName', SingleFieldColumnType::class);
        //...
    }
}

```

### Reference properties of a chain of related entities

Suppose you have the following entity classes (User, UserProfile and Address) which are realted between them::

```php
<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

class User
{    
    /**
     * @var UserProfile
     */
    private $profile;
    
    public function getProfile()
    {
        return $this->profile;
    }
}

```

```php
<?php
// src/AppBundle/Entity/UserProfile.php
namespace AppBundle\Entity;

class UserProfile
{    
    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var Address
     */
    private $address;
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
}

```

```php
<?php
// src/AppBundle/Entity/Address.php
namespace AppBundle\Entity;

class Address
{    
    private $street;
    
    public function getStreet()
    {
        return $this->street;
    }
}
```

You can access in a column properties of another related entities (only through one to one and many to one relationship).

```php
<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Jagilpe\EntityListBundle\Controller\EntityListControllerTrait;
use Jagilpe\EntityListBundle\EntityList\ColumnType\SingleFieldColumnType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    use EntityListControllerTrait;
    
    public function userProfileListAction()
    {
        //...
        // A property of the related profile
        $listBuilder->add('profile::firstName', SingleFieldColumnType::class);
        
        // A property of the address of the related profile
        $listBuilder->add('profile::address::street', SingleFieldColumnType::class);
        //...
    }
}

```

## DateTimeColumnType

Is the same as the SingleFieldColumnType with the exception that the type of the value that will be rendered in the 
cell is an instance of \DateTime. If you use the SingleFieldColumnType for rendering a \DateTime property and you
sort the table by this column you'll get it sorted alphabetically by the rendered value of the cell. With this column
type the table will be sorted chronologically by this field.

## CallbackColumnType

With this column type you can specify a callable to get the value that will be rendered in the column. This callable 
get as parameter the object that corresponds to the row it's being rendered. This column type is very powerful, specially
in combination with an entity list class (see below) in which you can access services through the dependency injection
of Symfony.

```php
<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Jagilpe\EntityListBundle\Controller\EntityListControllerTrait;
use Jagilpe\EntityListBundle\EntityList\ColumnType\CallbackColumnType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

function myFunction(UserProfile $profile) {
    $now = new \DateTime();
    return $profile && $profile->getBirthDate() ? $now->diff($profile->getBirthDate())->y : null;
}

class DefaultController extends Controller
{
    use EntityListControllerTrait;
    
    public function userProfileListAction()
    {
        //...
        // A regular function
        $listBuilder->add('Age', CallbackColumnType::class, array('content-callback' => 'myFunction'));
        
        // A closure
        $now = new \DateTime();
        $listBuilder->add('Age', CallbackColumnType::class, array(
            'content-callback' => function (UserProfile $profile) use ($now) { 
                return $profile && $profile->getBirthDate() ? $now->diff($profile->getBirthDate())->y : null;
            }));
        
        // A public method of the class
        $listBuilder->add('Age', CallbackColumnType::class, array(
            'content-callback' => array($this, 'getUserAge')));
        //...
    }
    
    public function getUserAge(UserProfile $profile)
    {
        $now = new \DateTime();
        return $profile && $profile->getBirthDate() ? $now->diff($profile->getBirthDate())->y : null;
    }
}

```

# Create an entity list class

An entity list can be created and used directly in a controller. However, a better practice is to build the entity list 
in a separate, standalone PHP class, which can then be reused anywhere in your application. Create a new class that will 
house the logic for building the entity list.

```php
<?php
// src/AppBundle/EntityList/UserProfileListType.php
namespace AppBundle\EntityList\Type;

use AppBundle\Entity\UserProfile;
use Jagilpe\EntityListBundle\EntityList\AbstractListType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\CallbackColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\SingleFieldColumnType;
use Jagilpe\EntityListBundle\EntityList\EntityListBuilderInterface;

class UserProfileListType extends AbstractListType
{
    public function buildList(EntityListBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('firstName', SingleFieldColumnType::class, array('label' => 'Username'))
            ->add('fullName', CallbackColumnType::class, array(
                'label' => 'Full name',
                'content-callback' => function(UserProfile $userProfile) {
                    return $userProfile ? $userProfile->getLastName().', '.$userProfile->getFirstName() : null;
                }))
            ->add('Age', CallbackColumnType::class, array(
                'content-callback' => array($this, 'getUserAge')
            ))
        ;
    }

    public function getUserAge(UserProfile $profile)
    {
        $now = new \DateTime();
        return $profile && $profile->getBirthDate() ? $now->diff($profile->getBirthDate())->y : null;
    }
}
```

Now you can use it in your controller:

```php
<?php

namespace AppBundle\Controller;

use AppBundle\EntityList\Type\UserProfileListType;
use Jagilpe\EntityListBundle\Controller\EntityListControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    use EntityListControllerTrait;

    public function userProfileListAction()
    {
        // Get the user profiles
        $profiles = $this->get('some_service')->getUserProfiles();
        
        // Get an entity list builder for the given profiles
        $list = $this->createEntityList($profiles, UserProfileListType::class);
        
        // Return the page
        return $this->render('default/user_profile_list.html.twig', array('list' => $list,));
    }
}
```

## Accessing services from your entity list type

You can inject any dependency available in the container of your project in your entity list type class.

```php
<?php
// src/AppBundle/EntityList/UserProfileListType.php
namespace AppBundle\EntityList\Type;

use AppBundle\Entity\UserProfile;
use AppBundle\Service\MyService;
use Jagilpe\EntityListBundle\EntityList\AbstractListType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\CallbackColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnType\SingleFieldColumnType;
use Jagilpe\EntityListBundle\EntityList\EntityListBuilderInterface;

class UserProfileListType extends AbstractListType
{
    private $myDepedency;
    
    public function __construct(MyService $myDependency) {
        $this->myDependency = $myDependency;
    }
    
    public function buildList(EntityListBuilderInterface $builder, array $options = array())
    {
        // Add fields dynamically
        if ($this->myDependency->showFirstName()) {
            $builder->add('firstName', SingleFieldColumnType::class, array('label' => 'Username'));
        }
        
        // Pass the dependency to a closure
        $myDependency = $this->myDependency;
        $builder->add('Is active', CallbackColumnType::class, array(
            'label' => 'Full name',
            'content-callback' => function(UserProfile $userProfile) use($myDependency) {
                return $myDependency->isUserActive($userProfile) ? 'yes' : 'no';
            }));
            
         $builder->add('Rating', CallbackColumnType::class, array(
                'content-callback' => array($this, 'getUserRating')
            ))
        ;
    }

    public function getUserAge(UserProfile $profile)
    {
        // Use the dependency anywhere in the class
        return $this->myDependency->getUserRating($profile);
    }
}
```

To be able to inject the dependency in your entity list class you have to declare it as a service in your container tagged
with the tag `jgp_entity_list.list_type`.

```yaml
# src/AppBundle/Resources/config/services.yml
services:
    my_service:
        class: AppBundle\Service\MyService
        
    user_profile_list_type:
        class: AppBundle\EntityList\Type\UserProfileListType
        arguments:
            - "@my_service"
        public: false
        tags:
            - { name: 'jgp_entity_list.list_type' }
        
```

# Create custom column type

You can define your own column types to adapt them to your business logic. For this you can directly extend the
[Jagilpe\EntityListBundle\EntityList\ColumnType\AbstractColumnType](https://api.gilpereda.com/entity-list-bundle/master/Jagilpe/EntityListBundle/EntityList/ColumnType/AbstractColumnType.html)
class or any of the built-in column types.

```php
<?php
// src/AppBundle/EntityList/ColumnType/MyColumnType.php
namespace AppBundle\EntityList\ColumnType;

use Jagilpe\EntityListBundle\EntityList\ColumnType\CallbackColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;

class MyColumnType extends CallbackColumnType
{
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {
        $options['content-callback'] = array($this, 'getCellContent');
        parent::build($builder, $options);
    }

    public function getCellContent($entity)
    {
        return 'Buzz';
    }
}

```

In your entity list type, you can use it as any of the built-in types.

```php
<?php
// src/AppBundle/EntityList/UserProfileListType.php
namespace AppBundle\EntityList\Type;

use AppBundle\EntityList\ColumnType\MyColumnType;
use Jagilpe\EntityListBundle\EntityList\AbstractListType;
use Jagilpe\EntityListBundle\EntityList\EntityListBuilderInterface;

class UserProfileListType extends AbstractListType
{
    public function buildList(EntityListBuilderInterface $builder, array $options = array())
    {
        $builder->add('My custom column', MyColumnType::class);
    }
}
```


## Accessing services from your entity list type

As with the entity list type classes you can inject any dependency available in the container of your project in your 
column type class.

```php
<?php
// src/AppBundle/EntityList/ColumnType/MyColumnType.php
namespace AppBundle\EntityList\ColumnType;

use AppBundle\Service\MyService;
use Jagilpe\EntityListBundle\EntityList\ColumnType\CallbackColumnType;
use Jagilpe\EntityListBundle\EntityList\ColumnBuilderInterface;

class MyColumnType extends CallbackColumnType
{
    private $myDepedency;
        
    public function __construct(MyService $myDependency) {
        $this->myDependency = $myDependency;
    }
        
    public function build(ColumnBuilderInterface $builder, array $options = array())
    {
        $options['content-callback'] = array($this, 'getCellContent');
        parent::build($builder, $options);
    }

    public function getCellContent($entity)
    {
        return $this->myDependency->getCellValue($entity);
    }
}

```

Now you only have to define the column type as a service tagged with the tag `jgp_entity_list.column_type`.

```yaml
# src/AppBundle/Resources/config/services.yml
services:
    my_service:
        class: AppBundle\Service\MyService
        
    my_column_type:
        class: AppBundle\EntityList\ColumnType\MyColumnType
        arguments:
            - "@my_service"
        public: false
        tags:
            - { name: 'jgp_entity_list.column_type' }
        
```