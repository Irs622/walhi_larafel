<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'WALHI Jawa Barat',
            'titleBefore'  => false,
            'description'  => 'Organisasi gerakan lingkungan hidup independen terbesar di Jawa Barat. Memperjuangkan keadilan ekologis, pendampingan hukum agraria, dan perlindungan kawasan hutan.',
            'separator'    => ' - ',
            'keywords'     => ['WALHI', 'Jawa Barat', 'Lingkungan Hidup', 'Keadilan Ekologis', 'Advokasi Lingkungan', 'Hutan', 'Agraria'],
            'canonical'    => 'current',
            'robots'       => 'index, follow',
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'WALHI Jawa Barat - Advokasi Lingkungan & Keadilan Ekologis',
            'description' => 'Organisasi gerakan lingkungan hidup independen terbesar di Jawa Barat. Memperjuangkan keadilan ekologis, pendampingan hukum agraria, dan perlindungan kawasan hutan.',
            'url'         => null,
            'type'        => 'website',
            'site_name'   => 'WALHI Jawa Barat',
            'images'      => ['/assets/images/resources/logo-2-walhi.png'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
            'site'        => '@walhijabar',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'WALHI Jawa Barat',
            'description' => 'Organisasi gerakan lingkungan hidup independen terbesar di Jawa Barat. Memperjuangkan keadilan ekologis, pendampingan hukum agraria, dan perlindungan kawasan hutan.',
            'url'         => 'current',
            'type'        => 'WebSite',
            'images'      => ['/assets/images/resources/logo-2-walhi.png'],
        ],
    ],
];
