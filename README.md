#Mapper

Paquete PHP agnóstico a frameworks provee una forma fácil con la cual mapear los atributos especificado en los DocComments de una clase, también permite agregar funcionalidad extra a través de mutators y accesors (setNameAttribute, getNameAttribute) al estilo de los Modelos de Laravel.


##1. Por qué Mapper?

> El Principio de lo Explicito establece: Intenta siempre favorecer lo explícito sobre lo implícito.

Ser explicito a la hora de hacer código es algo que ayudara a quien hace el código y a sus posibles sucesores a la hora de entender que es lo que esta pasando. Ejemplo:


```
    class Customer{
        public function store($name, $city){
            .....
        }
    
    }
```

Pero cuando tenemos un objeto con demasiados atributos ya no es tan fácil. **¡NO! la solución no es crear una función con más de 10 atributos.** , en la mayoría de casos la solución es pasar un array con todos los atributos. Algo así:

```
    class Customer{
        public function store(array $data){
            //En laravel
            $customer = new Customer();
            $customer->fill($data);
            $customer->save();
        }
    
    }
```
Sin embargo, esto no es para nada explicito, cualquiera que llegue tendrá que hacer seguimiento para poer entener que es lo que esta llegando en el array $data.

Con Mapper podrías hacer algo así:
```
    class Customer{
        public function store(CustomerMap $customerMap){
       
            //Option A
            $customer = new Customer();
            $customer->name = $customerMap->name;
            $customer->city = $customerMap->city;
            $customer->country = $customerMap->country;
            ..... 
            $customer->save();
             
            //Option B
            $customer = new Customer();
            $customer->fill($customerMap->getAttributes());
            $customer->save();
        }
    
    }
```

##2. Instalación

Ejecutar en consola 

``` composer require oscarricardosan/mapper ```

##3. Uso

###3.1. Definir una clase que extienda Mapper y tenga DocComments

Crea una clase que extienda a Mapper y en DocComments define las propiedades que van a ser mapeadas:

```
use Oscarricardosan\Mapper\Mapper;

/**
 * @property $name
 * @property $company "PHP Company" 
 * @property $document_type
 * @property $document_number
 * @property $city
 * @property $state
 * @property $country
 * @property $car
 */
 
class CustomerMap extends Mapper
{

}

$customerMap = new CustomerMap();
```
Con lo anterior **$customerMap** ha quedado con las propiedades que estaban en los DocComments incluyendo los valores por defecto:
```
    echo($customerMap->company);  => "PHP Company" 
    echo($customerMap->name);  => null 
```

###3.2. Cargar valores 

Existen dos formas para cargar valores a una clase que extiende de Mapper:

####3.2.1. Forma masiva 

Ya sea por el __construct o por setAttributesFromArray, si la propiedad que viene en el array no esta declarada en los DocComments el la omitirá.
 
```
    $sample = [
        'name' => 'oscar',
        'document_type' => 'cc',
        'document_number' => '000255',
        'country' => 'Colombia',
        'city' => 'Moscú',
        'state' => 'Bogota',
        'car' => 'toyota',
    ];
```
Desde el constructor

```
    $customerMap = new CustomerMap($sample);
    echo($customerMap->name);  => oscar
```
Con el método **setAttributesFromArray**
```
    $customerMap = new CustomerMap();
    $customerMap->setAttributesFromArray($ssample);
    echo($customerMap->name);  => oscar
```


####3.2.2. Como propiedad

```
    $customerMap = new CustomerMap();
    $customerMap->name  = 'oscar';
    echo($customerMap->name);  => oscar
```
**NOTAS:**
* Si asignas un valor a una propiedad que no esta definida en los DocComments no tendrá efecto y la propiedad retornara null.
>```
>    $customerMap->otherProperty = 'value';
>    var_dump($customerMap->otherProperty);  => NULL
>```

* Los valores por defecto establecidos en DocComments permaneceran hasta que no los remplazes ya sea por un array[] o de forma directa ->.
>```
>    echo($customerMap->company);  => PHP Company
>    $customerMap->company = 'Cbot' 
>    echo($customerMap->company);  => Cbot 
>```


###3.3. Mutators y Accessors

Siguiendo la sintaxis de los modelos en Laravel podemos declarar mutators y accessors en la clase que extiende Mapper. En ellos puedes dejar la lógica para depurar los datos que generalmente nos llegan por request y que se pierde en el controlador al no ser reutilizable. 

```
use Oscarricardosan\Mapper\Mapper;

/**
 * @property $name
 * @property $company "PHP Company"
 * @property $document_type "cc"
 * @property $document_number
 * @property $city
 * @property $state
 * @property $country
 * @property $car
 */
class CustomerMap extends Mapper
{
    public function getDocumentTypeAttribute($value)
    {
        return strtoupper($value);
    }
    public function setCityAttribute($value)
    {
        if($value == 'Moscú')
            $this->attributes['country'] = 'Rusia';
    }
}

//Accessor default value
echo($customerMap->document_type);  => CC

//Accessor new value
$customerMap->document_type = 'ti';
echo($customerMap->document_type);  => TI


//Mutator
$customerMap->city = 'Moscú';
echo($customerMap->country);  => Rusia

```


##4. Ejemplo usando un Controlador y un Repositorio

```
    #Laravel
    
    /***
       * REPOSITORY
    ***/
    class CustomerRepository{
        public function store(CustomerMap $customerMap)
        {
            $customer = new Customer();
            $customer->fill($customerMap->getAttributes());
            $customer->save();
        }
        public function update(CustomerMap $customerMap)
        {
            $customer = new Customer();
            $customer->name = $customerMap->name;
            $customer->name = $customerMap->company;
            $customer->save();
        }
    }
    
    /***
       * CONTROLLER
    ***/
    class CustomerController{
        $repository;
        public function __construct(){
            $this->repository =  new CustomerRepository();   
        }
        
        public function store($request)
        {
           $customerMap = new CustomerMap($request->all());
           $this->repository->store($customerMap);
        }
        
        public function update($request)
        {
           $customerMap = new CustomerMap($request->all());
           $this->repository->update($customerMap);
        }
    }
```