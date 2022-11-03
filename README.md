# laravel-uoc
__Api creada en [PHP](https://www.php.net/) para una red social de imágenes, con comentarios y likes. Parte de servidor__  
   
## Estructura de la api  

### Users  
Perfiles de usuario con roles (anonymous/user/admin)   

"/users"              - __post__ - Registro de usuarios, encripta los passwords con SHA256  
"/users/login"        - __post__  - Login de usuario  
"/users"              - __get__  - Listado de todos los usuarios. Exclusivo admin  
"/users/{id:[0-9]+}"  - __get__  - Detalles de un usuario en concreto.  
"/users/{id:[0-9]+"   - __put__  - Editar un usuario. No se puede cambiar ID ni username. El role solo lo puede cambiar un admin 
