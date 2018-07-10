# TP_PROG3_1C_2018
"la comanda" TP obligatorio

#Cómo usarlo?

#Para obtener token
http://sofiainessartori.000webhostapp.com/apirest.php/login/
Método=POST
Parametros= usuario, clave
Usuario administrador= usuario=sofiasar clave=sofiasar

#IMPORTANTE
La clave del token es: restaurantlolo
Las claves de los usuarios, son iguales a su nombre de usuario

#Para acciones sobre los usuarios:
Sólo administradores / usuario=sofiasar clave=sofiasar

-Dar de alta usuario: http://sofiainessartori.000webhostapp.com/apirest.php/usuario/
Método=POST
Parametros= nombre, apellido, usuario, clave, area (gerencia, salon, barra, cocina), perfil (socio, mozo, cervecero, bartender, cocinero)

-Consultar todos los usuarios: http://sofiainessartori.000webhostapp.com/apirest.php/usuario/
Método= GET

-Consultar un usuario: http://sofiainessartori.000webhostapp.com/apirest.php/usuario/uno/{id_usuario}/
Método = GET

-Consultar días y horario que los usuarios ingresaron: http://sofiainessartori.000webhostapp.com/apirest.php/usuario/dias/
Método=GET

-Consultar las operaciones por area: http://sofiainessartori.000webhostapp.com/apirest.php/operaciones/area/{area}
Método=GET

-Consultar las operaciones por area listadas por empleados: http://sofiainessartori.000webhostapp.com/apirest.php/operaciones/areaEmpleado/{area}
Método=GET

-Consultar las operaciones de un usuario: http://sofiainessartori.000webhostapp.com/apirest.php/operaciones/empleado/{usuario}
Método=GET

-Dar de baja a un usuario: http://sofiainessartori.000webhostapp.com/apirest.php/usuario/
Parámetros= usuario
Método= DELETE

-Cambiar el estado de un usuario (como por ejemplo, suspenderlo): http://sofiainessartori.000webhostapp.com/apirest.php/usuario/
Parámetros= usuario, estado(suspendido, activo, borrado)
Método= PUT

#Para acciones sobre las comandas:

-Traer el estado y tiempo de una comanda: http://sofiainessartori.000webhostapp.com/apirest.php/comanda/{codigo}/
Parámetros=codigo
Método=GET
Cualquier persona puede consultar

-Tomar un pedido:http://sofiainessartori.000webhostapp.com/apirest.php/comanda/
Parámetros=mesa(numero de mesa), usuario(id de usuario), foto, cliente(nombre del cliente), item[0][item] (id de item), item[0][cantidad] (cantidad del item)
Método=POST

-Cancelar un pedido: http://sofiainessartori.000webhostapp.com/apirest.php/comanda/
Parámetros=codigo
Método=DELETE
Sólo los mozos pueden cancelar

#Para acciones sobre los pedidos:

-Traer todos los pedidos pendientes para el trabajador: http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/
Header= debe ingresar su token
Método= GET 

-Traer los productos que más se vendieron: http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/masVendidos/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Traer los productos que menos se vendieron: http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/menosVendidos/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Mostrar los pedidos cancelados: http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/cancelados/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Establecer tiempo para el pedido (trabajador): http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/
Header= debe ingresar su token
Parámetros= tiempo, codigo(codigo alfanumerico de la comanda)
Método=PUT

-Pasar el pedido a listo para servir (trabajdor): http://sofiainessartori.000webhostapp.com/apirest.php/pedidos/
Header= debe ingresar su token
Parámetros= codigo(codigo alfanumerico de la comanda)
Método=DELETE

#Para acciones sobre las mesas:

-Para abrir una mesa: http://sofiainessartori.000webhostapp.com/apirest.php/mesa/
Parámetros=mesa(numero de la mesa)
Método=POST
Cualquiera puede abrirla

-Para mostrar todas las mesas: http://sofiainessartori.000webhostapp.com/apirest.php/mesa/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para ver el estado de una mesa:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/{id_mesa}/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa mas usada:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/masUsada/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa menos usada:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/menosUsada/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa con menos facturacion:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/menosFacturacion/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa con mas facturacion:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/masFacturacion/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa con mejor comentario:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/mejorComentario/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para mostrar la mesa con peor comentario:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/mesas/peorComentario/
Método=GET
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para consultar la facturacion de una mesa entre fechas:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/facturacion/
Parámetros=mesa(numero de la mesa), fecha_inicio, fecha_fin
Método=POST
Sólo administradores / usuario=sofiasar clave=sofiasar

-Para cambiar el estado de una mesa:http://sofiainessartori.000webhostapp.com/apirest.php/mesa/
Parámetros=mesa(numero de la mesa),estado
Método=PUT
Sólo mozos 

-Para cerrar una mesa: http://sofiainessartori.000webhostapp.com/apirest.php/mesa/
Parámetros=mesa(numero de la mesa)
Método=DELETE
Sólo administradores / usuario=sofiasar clave=sofiasar