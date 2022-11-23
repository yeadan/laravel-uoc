# laravel-uoc
__Api creada en [PHP](https://www.php.net/) para una red social de imágenes, con comentarios y likes. Parte de servidor__  
   
## Puesta en marcha   
   
Instalar las dependencias 
```bash
composer install
```
   
Arrancar el servidor
```bash
php artisan serve
```
   
## Estructura de la api (prefijo /api/ antes de cada ruta)   

### Users  
   
/user	- GET - Devuelve el usuario actual      
/user	- PUT - Modifica los datos del usuario actual   
/users -	GET -	Devuelve todos los usuarios registrados   
/login -	POST - Identificarse un usuario existente en la aplicación   
/register -	POST - Registrar un usuario nuevo en la aplicación   
/user/{id} - GET - Devuelve los datos del usuario escogido con el ID   
        
### Images   
   
/image - POST - Sube una imagen, solo para usuarios registrados    
/image/{id} - GET - Devuelve el link donde está guardada una imagen   
   
### Posts   
   
/post - POST - Creación de un post   
/post/{id} - PUT - Edición de un post escogido con el ID   
/post/{id} - DELETE - Borrado del post con el ID correspondiente   
/post/{id} - GET - Seleccionamos el post escogido con el ID   
/post - GET - Devuelve todos los posts   
   
### Comments   
   
/comment - POST - Creación de un comentario   
/comment/{id} - PUT - Edición de un comentario escogido con el ID   
/comment/{id} - DELETE - Borrado del comentario con el ID correspondiente   
/comment/{id} - GET - Seleccionamos el comentario escogido con el ID   
/comment - GET - Devuelve todos los comentarios   
/comments/{id} - GET - Devuelve todos los comentarios del post escogido con el ID   
   
### Likes   
   
/like - POST - Crear un like   
/like/{id} - DELETE - Borrar el like escogido con el ID   
/like/{id} - GET - Seleccionar un like escogido con el ID   
/like - GET - Seleccionar todos los likes   
/likes/{id} - GET - Seleccionar todos los likes de un post escogido con el ID   
   
