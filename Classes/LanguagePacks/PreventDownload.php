<?php

declare(strict_types=1);

/*
 * This file is part of the "prevent_lang_packs_download" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\PreventLangPacksDownload\LanguagePacks;

use Brotkrueml\PreventLangPacksDownload\Extension;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent;

final class PreventDownload
{
    /**
     * @var list<string>
     */
    private readonly array $excludeList;

    public function __construct(
        ExtensionConfiguration $extensionConfiguration,
    ) {
        $this->excludeList = GeneralUtility::trimExplode(
            ',',
            $extensionConfiguration->get(Extension::KEY, 'excludeList'),
            true,
        );
    }

    public function __invoke(ModifyLanguagePacksEvent $event): void
    {
        if ($this->excludeList === []) {
            return;
        }

        $extensions = \array_keys($event->getExtensions());
        foreach ($extensions as $key) {
            if ($this->shouldRemoveExtension($key)) {
                $event->removeExtension($key);
            }
        }
    }

    private function shouldRemoveExtension(string $key): bool
    {
        foreach ($this->excludeList as $pattern) {
            if ($this->matchesKeyWithWildcardAtEnd($key, $pattern)) {
                return true;
            }
            if ($key === $pattern) {
                return true;
            }
        }

        return false;
    }

    private function matchesKeyWithWildcardAtEnd(string $key, string $pattern): bool
    {
        $pattern = \rtrim($pattern, '*');

        if ($pattern === '') {
            return true;
        }

        return \str_starts_with($key, $pattern);
    }
}
