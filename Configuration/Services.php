<?php


use Brotkrueml\PreventLangPacksDownload\LanguagePacks\PreventDownload;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $configurator): void {
    $services = $configurator->services();
    $services
        ->defaults()
        ->autoconfigure()
        ->autowire()
        ->private();

    $services
        ->load('Brotkrueml\PreventLangPacksDownload\\', '../Classes/*')
        ->exclude('../Classes/Extension.php');

    $services->set(PreventDownload::class)
        ->tag('event.listener', [
            'identifier' => 'prevent-lang-packs-download/prevent-download',
        ]);
};
