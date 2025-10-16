<?php

declare(strict_types=1);

/*
 * This file is part of the "prevent_lang_packs_download" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\PreventLangPacksDownload\Tests\Unit\LanguagePacks;

use Brotkrueml\PreventLangPacksDownload\Extension;
use Brotkrueml\PreventLangPacksDownload\LanguagePacks\PreventDownload;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent;

#[CoversClass(PreventDownload::class)]
final class PreventDownloadTest extends TestCase
{
    private ExtensionConfiguration&Stub $extensionConfigurationStub;
    private ModifyLanguagePacksEvent $event;

    protected function setup(): void
    {
        $this->extensionConfigurationStub = self::createStub(ExtensionConfiguration::class);

        // The values are of no interest, as we only work with the keys
        $extensions = [
            'adminpanel' => [],
            'backend' => [],
            'belog' => [],
            'core' => [],
            'extbase' => [],
            'filelist' => [],
            'fluid' => [],
            'fluid_styled_content' => [],
            'frontend' => [],
            'install' => [],
            'setup' => [],
            'tstemplate' => [],
            'matomo_integration' => [],
            'matomo_optout' => [],
            'matomo_widgets' => [],
        ];
        $this->event = new ModifyLanguagePacksEvent($extensions);
    }

    #[Test]
    #[DataProvider('emptyExcludeListProvider')]
    public function emptyExcludeListRemovesNoExtensions(string $excludeList): void
    {
        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'excludeList')
            ->willReturn($excludeList);

        $subject = new PreventDownload($this->extensionConfigurationStub);

        $numberOfExtensionsBefore = \count($this->event->getExtensions());

        $subject->__invoke($this->event);

        self::assertCount($numberOfExtensionsBefore, $this->event->getExtensions());
    }

    public static function emptyExcludeListProvider(): iterable
    {
        yield 'with empty string' => [
            '',
        ];

        yield 'with space' => [
            ' ',
        ];

        yield 'with a comma' => [
            ',',
        ];

        yield 'with commas and space' => [
            '  , , ',
        ];
    }

    #[Test]
    public function excludeListWithOneEntryAndDistinctExtensionKey(): void
    {
        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'excludeList')
            ->willReturn('belog');

        $subject = new PreventDownload($this->extensionConfigurationStub);

        $numberOfExtensionsBefore = \count($this->event->getExtensions());

        $subject->__invoke($this->event);

        self::assertCount($numberOfExtensionsBefore - 1, $this->event->getExtensions());
        self::assertArrayNotHasKey('belog', $this->event->getExtensions());
    }

    #[Test]
    public function excludeListWithOneEntryAndWildcardAtEnd(): void
    {
        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'excludeList')
            ->willReturn('matomo_*');

        $subject = new PreventDownload($this->extensionConfigurationStub);

        $numberOfExtensionsBefore = \count($this->event->getExtensions());

        $subject->__invoke($this->event);

        self::assertCount($numberOfExtensionsBefore - 3, $this->event->getExtensions());
        self::assertArrayNotHasKey('matomo_integration', $this->event->getExtensions());
        self::assertArrayNotHasKey('matomo_optout', $this->event->getExtensions());
        self::assertArrayNotHasKey('matomo_widgets', $this->event->getExtensions());
    }

    #[Test]
    public function multipleEntriesInExcludeList(): void
    {
        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'excludeList')
            ->willReturn('fluid*, setup, matomo_integration');

        $subject = new PreventDownload($this->extensionConfigurationStub);

        $numberOfExtensionsBefore = \count($this->event->getExtensions());

        $subject->__invoke($this->event);

        self::assertCount($numberOfExtensionsBefore - 4, $this->event->getExtensions());
        self::assertArrayNotHasKey('fluid', $this->event->getExtensions());
        self::assertArrayNotHasKey('fluid_styled_content', $this->event->getExtensions());
        self::assertArrayNotHasKey('matomo_integration', $this->event->getExtensions());
        self::assertArrayNotHasKey('setup', $this->event->getExtensions());
    }
}
