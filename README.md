# rayuela-store
## Proyecto de pasaje de grado
-------------------


### TO-DO Actual (19/10/24)
(Tareas por hacer que surgen del úso de la aplicación, errores, mejoras, etc. Por lo tanto puede no contener los RF o RNF a desarrollar)
----------------------

#### Programación
- Hacer temporales los mensajes de exito o fracaso al realizar operaciones con el CRUD.
- Verificar que la imagen a eliminar no este siendo utilizada en una categoría u otro producto, en dicho caso no borrar dicha imagen, si datos referentes al producto en la base de datos.(Opcional)
- Evitar que el administrador pueda eliminar las categorias si estas estan relacionadas a productos existentes o que se pueda pero se borren los productos, mostrar advertencia.
- Realizar la logica del perfil de usuario
- Añadir restriccion para que el admin no agregue productos ya presentes en la base de datos(Comprobar por Nombre y/o descripcion)
- Permitir que se agreguen imagenes(a BBDD) cuando se modifica el producto.(O que no se agreguen a los archivos y que se reciba un msj de feedback)
- Sanear todos los mensajes a usuario mediante htmlspecialchars.
- Realizar un header con un require para comprobar sesiones y variables de sesiones.

#### Diseño Web
- Mejorar los diseños en general, prioridad en las paginas que ven los usuarios/clientes.
- Terminar diseño de perfiles de usuario

#### General

- Corregir faltas de ortografía en msj a usuarios.