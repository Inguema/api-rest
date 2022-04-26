<h1>Api Rest Laravel 8</h1>

Una vez descargado el repositorio...

Seguir los pasos siguientes para probar la ejecución del proyecto api-rest:

1- Renombrar el .env.example en .env

2- Generar clave key con el siguiente comando:
   php artisan key:generate (Este paso en este caso no es necesario ya que la key está en .env.example. Añado este punto ya que al descargarme el proyecto en otro ordenador, he tenido que realizar este paso, pero ahora con la información copiada en .env.example, ya no será necesario.)

3- Crear la bbdd con el nombre que hemos utilizado en el archivo .env. Ejemplo: en este proyecto se llama passport_db

4- Ejecutar el siguiente comando:
````php artisan migrate:refresh --seed````

5- Ejecutar el siguiente comando para instalar passport
````php artisan passport:install --force````

<hr>
Datos a tener en cuenta:

- La carpeta _data contiene los archivos del proyecto usados en Postman para realizar las correspondientes pruebas.


- El proyecto dispone de dos tipos de roles: admin y usuario. Admin cuenta con los permisos de editar y visualizar, mientras que User solo tendrá permiso para visualizar.

````
Usuario Admin:
    'name' => 'Admin',
    'email' => 'admin@prueba.es',
    'password' => bcrypt('admin123')
````
- Por defecto, api-rest, a cada usuario nuevo registrado le asignará el rol de user.
