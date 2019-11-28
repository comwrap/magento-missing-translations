This module functionality is to detect phrases that are not translated, i.e. those phrases that may appear to the end user as in their original phrasing, regardless of active/current locale.

To install:
 - bin/magento module:enable Comwrap_TranslatedPhrases
 - bin/magento setup:upgrade
 - bin/magento setup:di:compile

To use the module:
 - bin/magento i18n:non-translated:detect

The output is a file, containing current date in the name and ends with a .list extension, that is located in the /var folder. 

