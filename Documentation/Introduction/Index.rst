.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _what-it-does:

What does it do?
================

The extension provides the ability to prevent the download of language packs for
configurable extension keys.

This can be useful, for example, for project-specific extensions. It avoids
connections to the TYPO3 translation server, which only returns a 404 (not
found), and thus helps to reduce the environmental footprint. In addition,
private extension keys are not leaked to the translation server.

.. _command:

To see a list of the processed language packs, use the :bash:`language:update`
command with the :bash:`-v` option ("verbose") on the console:

.. tabs::

   .. group-tab:: Composer-based installation

      .. code-block:: bash

         vendor/bin/typo3 language:update -v

   .. group-tab:: Legacy installation

      .. code-block:: bash

         typo3/sysext/core/bin/typo3 language:update -v

For example, you will see a similar output:

.. code-block:: plaintext

   Updating language packs
   Updated pack for language "de" for extension "adminpanel"
   Updated pack for language "de" for extension "backend"
   Updated pack for language "de" for extension "belog"
   Updated pack for language "de" for extension "beuser"
   Updated pack for language "de" for extension "core"
   Fetching pack for language "de" for extension "myproject_site" failed
   ...

The :ref:`t3coreapi:ModifyLanguagePacksEvent` is used under the hood. Of course
you can implement this functionality in your own projects. This extension saves
you time because you do not have to code the event listener for each project,
but only configure the extensions that should be excluded.


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
