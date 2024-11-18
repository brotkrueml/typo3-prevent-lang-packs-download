.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _what-it-does:

What does it do?
================

The extension provides the possibility to prevent language packs download for
configurable extension keys.

This can be helpful, for example, for project-specific extensions. It avoids
connections to the TYPO3 translation server which returns just a 404 and helps
therefore to reduce the environmental footprint. Additionally, private extension
keys are not leaked to the translation server.

.. _command:

To see a list of the updated language packs, use the :bash:`language:update`
command with the :bash:`-v` option on console:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 language:update -v

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 language:update -v

For example, the following output is visible:

.. code-block:: plaintext

   Updating language packs
   Updated pack for language "de" for extension "adminpanel"
   Updated pack for language "de" for extension "backend"
   Updated pack for language "de" for extension "belog"
   Updated pack for language "de" for extension "beuser"
   Updated pack for language "de" for extension "core"
   ...

Extensions without a language pack for a configured language or with a disabled
language pack are not displayed.

Under the hood the :ref:`ModifyLanguagePacksEvent <t3coreapi:ModifyLanguagePacksEvent>`
is used. Of course, you can implement it on your own in your projects. This
extension saves time as you do not have to code the event listener by yourself
for each project, but just to configure the extensions which should be excluded.


Release management
==================

This extension uses `semantic versioning`_ which basically means for you, that

*  Bugfix updates (for example, 1.0.0 => 1.0.1) just includes small bug fixes or
   security relevant stuff without breaking changes.
*  Minor updates (for example, 1.0.0 => 1.1.0) includes new features and smaller
   tasks without breaking changes.
*  Major updates (for example, 1.0.0 => 2.0.0) breaking changes which can be
   refactorings, features or bug fixes.

.. _semantic versioning: https://semver.org/
