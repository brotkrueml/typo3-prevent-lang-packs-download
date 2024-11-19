.. include:: /Includes.rst.txt


.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**

Extension configuration
=======================

Configure the extension keys that should be excluded from downloading language
packs from the official TYPO3 translation server.

In the backend, navigate to :guilabel:`Admin Tools > Settings`, click on
:guilabel:`Configure Extensions` and then on
:guilabel:`prevent_lang_packs_download`:

.. figure:: /Images/extension-configuration.png
   :alt: Extension configuration

   Extension configuration

The exclude list is empty by default. You can enter one or more extension keys,
separated by commas. In addition, you can use a wildcard at the end to exclude
extensions that begin with a specific extension key.

Some examples:

`my_extension`
   Excludes the extension with the key `my_extension`.

`some_extension, another_extension`
   Excludes the extensions with the keys `some_extension` and `another_extension`.

`myproject_*`
   Excludes the extensions, for example, with the keys `myproject_site`,
   `myproject_video` or `myproject_download`.

After saving you can check your configuration with the
:ref:`language:update <command>` command. The excluded extensions should not be
listed.
