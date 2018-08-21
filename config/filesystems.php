<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [
        'Noticias' => [
            'driver' => 'local',
            'root' => public_path().'/Noticias',
            'visibility' => 'public',
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],
        
        'multimedia-atraccion' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/atracciones',
            'visibility' => 'public',
        ],
        
        'multimedia-actividad' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/actividades',
            'visibility' => 'public',
        ],
        
        'multimedia-destino' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/destinos',
            'visibility' => 'public',
        ],
        
        'multimedia-evento' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/eventos',
            'visibility' => 'public',
        ],

        'multimedia-ruta' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/rutas',
            'visibility' => 'public',
        ],
        
        'multimedia-proveedor' => [
            'driver' => 'local',
            'root' => public_path().'/multimedia/proveedores',
            'visibility' => 'public',
        ],
         'Publicaciones' => [
           'driver' => 'local',
           'root' => public_path().'/Publicaciones',
           'visibility' => 'public',
       ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

    ],

];
