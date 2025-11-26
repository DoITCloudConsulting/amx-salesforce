# AMX Salesforce

Este paquete proporciona una integración ligera con Salesforce para aplicaciones PHP usando la librería Omniphx/Forrest. Incluye:

- Un cliente (`SFClientService`) para ejecutar consultas SOQL, describir objetos y consumir la UI API.
- Clases base para representar objetos Salesforce (`SFBaseObject`) y traits generados con los campos.
- Una CLI embebida (`bin/salesforce`) con comandos para crear clases de objetos y sincronizar campos.

Este README explica cómo instalar y usar el paquete localmente, cómo configurar las credenciales y cómo usar los comandos `make-object` y `sync`.

## Requisitos

- PHP 8.2+
- Composer
- Variables de entorno de Salesforce (ver sección `.env`)

## Instalación (local / desarrollo)

1. Clona el repositorio o agrega el paquete como dependencia en tu proyecto.

Si trabajas directamente en este repositorio (instalación local):

```bash
# desde la carpeta donde está este repo
composer install
```

Si quieres probarlo desde otro proyecto, añade la dependencia a `composer.json` de ese proyecto o usa `path`/`repositories` para apuntar al repositorio local.

Ejemplo de `repositories` en `composer.json` (útil para desarrollo local cuando tienes paquetes locales). Usa una ruta relativa o absoluta que apunte al directorio del paquete:

```json
"repositories": [
  {
    "type": "path",
    "url": "../amx-salesforce"
  }
]
```

Con esto configurado en el `composer.json` del proyecto consumidor, puedes requerir el paquete localmente con:

```bash
composer require amx/salesforce:@dev
```

Alternativamente añade manualmente en `require` la línea `"amx/salesforce": "@dev"` y ejecuta `composer update`.

2. Asegúrate de instalar dependencias de paquetes (omniphx/forrest, symfony/console, vlucas/phpdotenv).

3. El paquete incluye un archivo binario `bin/salesforce` que levanta una pequeña aplicación console basada en Symfony Console y configura Forrest con las credenciales definidas en variables de entorno.

## Configuración (.env)

El CLI y el cliente esperan encontrar variables de entorno. Crea un archivo `.env` en el directorio desde donde ejecutarás `bin/salesforce` (normalmente la raíz del proyecto) con al menos estas variables:

```
SF_CONSUMER_KEY=your_consumer_key
SF_CONSUMER_SECRET=your_consumer_secret
SF_USERNAME=your_sf_username
SF_PASSWORD=your_sf_password
# Opcionales
SF_AUTH=UserPassword
SF_CALLBACK_URI=http://localhost/callback
SF_LOGIN_URL=https://login.salesforce.com
```

Se incluye un archivo de ejemplo `.env.example` en la raíz del repositorio; cópialo a `.env` y reemplaza los valores con tus credenciales:

```bash
cp .env.example .env
# editar .env con tus credenciales
```

En Windows puedes copiarlo con:

```powershell
copy .env.example .env
```

El CLI y el cliente esperan encontrar variables de entorno. Crea un archivo `.env` en el directorio desde donde ejecutarás `bin/salesforce` (normalmente la raíz del proyecto) con al menos estas variables:

```
SF_CONSUMER_KEY=your_consumer_key
SF_CONSUMER_SECRET=your_consumer_secret
SF_USERNAME=your_sf_username
SF_PASSWORD=your_sf_password
# Opcionales
SF_AUTH=UserPassword
SF_CALLBACK_URI=http://localhost/callback
SF_LOGIN_URL=https://login.salesforce.com
```

Se incluye un archivo de ejemplo `.env.example` en la raíz del repositorio; cópialo a `.env` y reemplaza los valores con tus credenciales (ve arriba para el comando de copia).

El script `bin/salesforce` carga el `.env` y configura internamente Forrest antes de ejecutar los comandos.

Nota: guarda las credenciales con cuidado y usa mecanismos seguros para entornos de producción.

## Uso del CLI

El binario expone dos comandos principales:

- `salesforce:make-object` (alias interno `amx-salesforce:make-object`): crea una clase PHP para un objeto Salesforce y un trait para los campos.
- `amx-salesforce:sync` (alias `salesforce:sync`): sincroniza los campos de un objeto Salesforce y escribe/actualiza el trait correspondiente con las propiedades tipadas.

Ejemplos:

```bash
# Ejecutar ayuda
php bin/salesforce list

# Crear un objeto custom (por defecto crea un Custom con sufijo __c)
php bin/salesforce salesforce:make-object Translations

# Crear un objeto Standard (pasa --standard)
php bin/salesforce salesforce:make-object Account --standard

# Sincronizar campos desde la API (describe)
php bin/salesforce amx-salesforce:sync Translations

# Sincronizar usando la UI API (mode=ui)
php bin/salesforce amx-salesforce:sync Account --mode=ui
```

Comportamiento rápido:

- `make-object` crea dos archivos si no existen:
  - `src/Objects/Custom/SF<Nombre>.php` o `src/Objects/Standard/SF<Nombre>.php`
  - `src/Traits/Custom/SF<Nombre>Fields.php` o `src/Traits/Standard/SF<Nombre>Fields.php`

- `sync` utiliza la clase existente del objeto (busca en Standard y luego en Custom). Crea el trait si no existe y actualiza sus propiedades con los campos obtenidos desde Salesforce (filtrando campos no applicable, mapeando tipos a tipos PHP básicos nullable).

## Uso desde PHP (SFClientService y SFBaseObject)

El paquete expone `Amx\Salesforce\SFClientService` como cliente central. Ejemplos de uso:

```php
use Amx\Salesforce\SFClientService;

$client = new SFClientService();

# Consultas SOQL construidas
$records = $client
    ->select(['Id', 'Name'])
    ->from('Account')
    ->where(['Name', 'LIKE', '%Acme%'])
    ->limit(10)
    ->execute();

# Describe un objeto
$describe = $client->describe('Account');

# Llamada a la UI API
$ui = $client->uiObjectInfo('Account');
```

SFBaseObject simplifica la representación de objetos Salesforce. Ejemplo con una clase generada `SFAccount`:

```php
use Amx\Salesforce\Objects\Standard\SFAccount;

$account = new SFAccount();

# Buscar por Id
$res = $account->findById('001xx000003NGsYAAW', ['Id', 'Name', 'Phone']);

# Crear/actualizar
$account->Name = 'Acme Corp';
$result = $account->save();

# Sincronizar campos (puede invocarse desde CLI o directamente)
$fields = $account->sync('api');
```

### Patrones de uso de los objetos

Las clases de objeto (`SFAccount`, `SFCase`, `SFTracker_Trade_Site`, etc.) están diseñadas para usarse en dos patrones principales:

1) Instanciar con datos y reutilizar la misma instancia

```php
// Instancia y la carga con datos (por ejemplo, respuesta de la API)
$account = new SFAccount([
  'Id' => '001xx000003NGsYAAW',
  'Name' => 'Acme Corp',
  'Phone' => '555-1234'
]);

// Puedes llamar métodos sobre la misma instancia
$result = $account->save(); // update si tiene Id
$fields = $account->sync(); // sincroniza trait/propiedades si lo necesitas
```

2) Instanciar vacío y pasar datos después (útil para creación o uso puntual)

```php
// Instancia vacía
$account = new SFAccount();

// Asignas propiedades manualmente o hidratas con un array
$account->Name = 'Nuevo Cliente';
$account->Phone = '555-9876';

$result = $account->save(); // crea nuevo registro si no tiene Id

// Alternativamente hidratar desde un array
$account->hydrate(['Name' => 'Empresa X', 'Phone' => '555-0000']);
$account->save();
```

Notas:
- `hydrate()` asigna valores a propiedades públicas existentes y también guarda todo en `$attributes`.
- `setClient()` permite inyectar un `SFClientService` compartido (útil para tests o para reutilizar una instancia mockeada):

```php
use Amx\Salesforce\SFClientService;

$client = new SFClientService();
SFAccount::setClient($client);

# ahora todas las instancias usaran ese cliente compartido
$a = new SFAccount();
$a->findById(...);
```

Ejemplo concreto (dos formas equivalentes)

```php
// Forma A: instanciar con datos y usar el método directamente
$tracker = new SFTracker_Trade_Site([
  'Name' => 'Trade Tracker',
  'Status__c' => 'Active'
]);
$response = $tracker->save(); // save() internamente llama a client->create cuando no hay Id

// Forma B: crear una instancia separada y pasar los datos a la instancia que ejecuta el método
$trackerData = new SFTracker_Trade_Site(['Name' => 'Trade Tracker']);
$response = (new SFTracker_Trade_Site())->hydrate($trackerData->toArray())->save();
```

Notas sobre el cliente:

- `ensureAuthenticated()` usa Forrest::authenticate(). El binario configura Forrest con las credenciales del `.env`.
- `execute()` construye la consulta SOQL internamente. Usa métodos encadenables: `select`, `from`, `where`, `orderBy`, `limit`.

## Desarrollo y testing local

- Instala dependencias: `composer install`.
- Ejecuta el CLI localmente desde la raíz del repo: `php bin/salesforce`.

## Buenas prácticas y debugging

- Asegúrate de que el `.env` esté en el directorio donde ejecutas `php bin/salesforce`.
- Si recibes errores de autenticación, revisa las variables `SF_CONSUMER_*`, `SF_USERNAME` y `SF_PASSWORD`.
- Para ver más información sobre la respuesta de Salesforce, puedes usar directamente `$client->query($soql)` o revisar `Forrest` logs.

## Mapeo rápido de tipos

El comando `sync` mapeará tipos de Salesforce a tipos PHP nullable comunes (ej: `string`, `int`, `float`, `bool`) y generará propiedades públicas en el trait del objeto.
