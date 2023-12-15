# Documentation Technique 

## Description
OnlyOffice est un outil de bureau en ligne complet et polyvalent conçu pour améliorer la collaboration sur les documents, les feuilles de calcul et les présentations. Il offre une compatibilité étendue avec les formats MS Office et d'autres formats populaires. L'intégration d'only office à YesWiki permet aux utilisateurs de créer, visualiser, éditer et collaborer sur des documents directement depuis leur navigateur web.


## Utilisation
Les différents documents only office peuvent être utilisés dans les fiches Bazar pour afficher des tableaux blancs collaboratifs.


## Fonctionnalités Principales

### Whiteboard

Lors de la création d'un composant only office sur une nouvelle page certains champs sont requis : 
  - Un champs de sélection permettant le choix d'un document ( **Document, Spreadsheet, Presentation, Formulaire** )
  - Un champs height est présent afin de définir la taille de l'iframe
  - Un booléen **"onlyoffice"** égal à **true** permet l'assignation de l'attribute **onlyoffice="true"** à l'iframe afin de pouvoir l'identifier
  - Un attribut **url** est écrit après validation du formulaire pour afficher afin d'initialiser l'iframe.

### Fichiers Associés

#### Only office

IframeAction.php, onlyoffice.js, only-office.yaml, OnlyOfficeListField.php

## Installation

Une installation du service Only office sur votre environnement est nécessaire.
Nous avons choisi de l'installer via docker afin de profiter d'une version stable tout en un.

_Rappel : à travers cette installation vous utiliserez une version gratuite d'only office, certaines fonctionnalitées seront indisponibles tout comme le nomenclature de fichiers_

#### Docker


```bash
sudo docker run -i -t -d -p 80:80 \
    -v /app/onlyoffice/DocumentServer/logs:/var/log/onlyoffice  \
    -v /app/onlyoffice/DocumentServer/data:/var/www/onlyoffice/Data  \
    -v /app/onlyoffice/DocumentServer/lib:/var/lib/onlyoffice \
    -v /app/onlyoffice/DocumentServer/rabbitmq:/var/lib/rabbitmq \
    -v /app/onlyoffice/DocumentServer/redis:/var/lib/redis \
    -v /app/onlyoffice/DocumentServer/db:/var/lib/postgresql  onlyoffice/documentserver
    
```

_Libre à vous de changer le port_

Pour plus d'infos :
- [ONLYOFFICE / Docker-DocumentServer](https://github.com/ONLYOFFICE/Docker-DocumentServer)

### URLs OnlyOffice

Lors de la création d'un nouveau document only office, différentes urls sont appelées :

**Création d'un nouveau document** : [URL exemple](http://localhost/example/editor?fileExt=pptx)
**Édition du document** : [URL exemple](http://localhost/example/editor?fileName=new.pptx)

_L'extension du document varie en fonction du type de document choisi_

Une variable globale **'onlyoffice_url' => 'http://localhost/example/editor'** est à mettre en place de le _wakka.config.php_
