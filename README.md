This module functionality is to detect phrases that are not translated, i.e. those phrases that may appear to the end user as in their original phrasing, regardless of active/current locale.

To install:
 - bin/magento module:enable Comwrap_TranslatedPhrases
 - bin/magento setup:upgrade
 - bin/magento setup:di:compile

To use the module:
 - bin/magento i18n:non-translated:detect

The output is a file, containing current date in the name and ends with a .list extension, that is located in the /var folder.

Known limitations:
The Native parser is not applicable to Magento version 2.1.x

Resources usage:
During run, one PHP process will consume 100% of a given processor core that runs that process. The memory used tends to be low.

Time needed to process full /vendor and /app/code:
Depending on processing power, but it may take a couple of minutes to complete.

