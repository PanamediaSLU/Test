# Software developer test
Una prueba para unirse al equipo de desarrollo de Euromillions.com

## Que es la lotería EuroJackpot? 

***EuroJackpot*** es una lotería transnacional de Europa que cuenta con un bote mínimo de 10 millones de euros cada viernes. 
> El bote puede acumularse hasta llegar a un tope de 90 millones de euros, en caso de no haber ganadores.  

> Para completar un juego de EuroJackpot se seleccionan cinco números principales del 1 al 50 y dos números adicionales del 1 al 10.


[Ejemplo de resultados](https://euromillions.com/es/eurojackpot/resultados)

[Ejemplo para jugar](https://euromillions.com/es/eurojackpot/jugar) 

## Como empezar

Necesitas tener docker, docker-compose y PHP7 instalado en tu entorno.

Haz un clone del proyecto y lanza el fichero bootstrap.sh(entendemos que trabajas con Linux, Mac, BSD). 

Que hace el fichero bootstrap.sh ?

Descarga dos imágenes docker y arranca dos contenedores, mysql y phpunit, que mediante un alias podrás llamarlo desde 
la línea de comandos y así ejecutar los tests.

> Cuando el contenedor mysql arranca, crea una base de datos llamada **euromillions** con una tabla para almacenar el draw
que recojas de la API. Puedes acceder la bbdd por el puerto 3306 de tu máquina local.

Seguramente necesites añadir algún contenedor para hacer caching de los resultados, pero si no te da tiempo, no te preocupes.

Si necesitas alguna aclaración o encuentras algún error, escribe una issue en el repositorio. 

## Que hay que hacer

Como tenemos muchas integraciones con diferentes Apis, el test estará relacionado con estas.

Queremos recuperar los resultados del último sorteo de EuroJackpot. Para esto necesitarás
invocar a una API.

##### Por favor, cuando inicies la prueba, te pones en contacto con nosotros y te envíamos el endpoint y la api key necesaria para tener acceso. 

Tienes que diseñar sabiendo que esta api puede fallar en algún momento y necesitamos poder invocar a otra API para recuperar los
resultados(esta segunda API que implementes puede ser un fake).

El último resultado se visualiza en la home y recibimos muchas visitas(evita consultar a la bbdd para mostrar el resultado).

Este último resultado lo mostrarás por el terminal cuando invoquemos el script de inicio.

Puedes utilizar cualquier patrón de diseño que necesites, VO y sobretodo, test unitarios y de integración.

Intenta sobretodo centrarte en recuperar los datos que devuelva la API y almacenarlos para después visualizarlos. Sino te da tiempo de implementar el caching del resultado o no tienes más
ganas de seguir, no pasa nada, no te preocupes.

## Dudas

Puedes abrir una issue en este repositorio.

## Como enviar tu solución

Haz un pull request al repositorio. 
