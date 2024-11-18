.. include:: /Includes.rst.txt


.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**

Extension configuration
=======================

Configure the extension keys which provide no language pack on the official
TYPO3 translation server.

Navigate in the backend to :guilabel:`Admin Tools > Settings`, click on
:guilabel:`Configure Extensions` and then on
:guilabel:`prevent_lang_packs_download`:

.. figure:: /Images/extension-configuration.png
   :alt: Extension configuration

   Extension configuration

By default, the exclude list is empty. You can enter one or more extension keys,
separated by a comma. Additionally, a wildcard at the end can be used to exclude
extensions starting with a certain string.

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
