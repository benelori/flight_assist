CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Recommended modules
 * Installation
 * Configuration
 * Troubleshooting
 * FAQ
 * Maintainers

INTRODUCTION
------------

This module allows for integration of Signature Pad, an electronic-signing
script, into Drupal for both nodes (content) and the Field API (FAPI).

 * For a full description of the module, visit the project page:
   https://drupal.org/project/esign

 * To submit bug reports and feature suggestions, or to track changes:
   https://drupal.org/project/issues/esign

REQUIREMENTS
------------

This module requires the following module:

 * Libraries (https://www.drupal.org/project/libraries)
 * Field API (core)

It also requires the following third-party library:

 * Signature Pad 1.6+ (https://github.com/szimek/signature_pad)

RECOMMENDED MODULES
-------------------

 None

INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. See:
   https://drupal.org/documentation/install/modules-themes/modules-7
   for further information.

 * Download and extract the Signature Pad library into the libraries directory
   (usually "sites/all/libraries").

CONFIGURATION
-------------

 * For content, you can change the options within the field settings.
   - For FAPI, you can change the field options by setting the '#esign_options'
     parameter, and using the following keys in an associative array:

   - dotSize (default: 1)

   - minWidth (default: 0.5)

   - maxWidth (default: 2.5)

   - backgroundColor (default: 'rgba(0,0,0,0)')

   - penColor (default: 'rgba(0,0,0,1)')

   - velocityFilterWeight (default: 0.7)

TROUBLESHOOTING
---------------

 * If the signature field does not display, check the following:

   - Did you set the field to display?

   - Does your CSS allow the field to display?

FAQ
---

Q: The signature field isn't working!

A: Please make sure you're using the correct version of Signature Pad.

MAINTAINERS
-----------

Current maintainers:
 * Adam Weiss (greatmatter) - https://www.drupal.org/u/greatmatter

This project has been sponsored by:
 * Great Matter
   We create the software you need most.
   Specializing in Drupal-based systems, Great Matter designs, develops,
   and supports amazing software solutions for the most complicated needs.
   Visit https://www.greatmatter.com for more information.
