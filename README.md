#Object map

Un pequeño Paquete PHP agnóstico a frameworks, el cual provee una forma 
facil para especificar los atributos de un objeto con el fin de ser más explicito 
en nuestro código, muy diferente a lo que pasa cuando usamos un array.

Cuando tienes una entidad con demasiados atributos no los podemos 
pasar como atributos de la función - O_O te imaginas una función con 20 atributos O_O - 
es cuando pasamos la data como un array, algo así:

```
    #Laravel
    
    /***
       * REPOSITORY
    ***/
    class CustomerRepository{
        public function store(array $data)
        {
            $customer = new Customer();
            $customer->fill($data);
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
El problema de ello es que al ver código así no tienes la menor 
idea que atributos pueden estar llegando en ese array O.o , 
para saberlo tendrías que hacer seguimiento al código.

Con este paquete lo primero que crearías es una clase que extienda de 
ObjectMap donde definimos los atributos de nuestro objeto.

```
use Oscarsan\ObjectMap\ObjectMap;

class CustomerMap extends ObjectMap
{
    public $name = '';
    public $company = 'PHP Company';
    public $document_type;
    public $document_number;
    public $city;
    public $state;
    public $country;
    public $car;
}
```
Con lo anterior hemos definido las propiedades del objeto, también hemos 
dejado valores default a los atributos los cuales no seran modificdos a menos 
que tu los cambies.

Ya con la clase MapObject definido podemos hacer algo en nuestro repositorio como:

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
Esta capa nos permite un mayor control de lo que estamos inyectando a 
nuestro repositorio.

##Metodos

* **__construct(array $attributes = []):** llama a setAttributesArray. 
* **setAttributesArray(array $attributes = []):** recorre el array suministrado y 
si el key corresponde a un atributo del ObjectMap le asigna el valor a esa propiedad.
* **getAttributes():** retorna un array con las propiedades del objectMap.