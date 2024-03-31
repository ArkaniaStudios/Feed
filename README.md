# Plugin FeedCommand 🍲

Le plugin FeedCommand est un outil pratique pour les serveurs Minecraft qui permet aux joueurs de se nourrir rapidement et facilement. Avec une simple commande, les joueurs peuvent se nourrir eux-mêmes ou nourrir d'autres joueurs, en faisant une addition précieuse à n'importe quel serveur.

## Fonctionnalités 🛠️

- **Commande Simple**: La commande `/feed` rend facile pour les joueurs de se nourrir eux-mêmes ou d'autres joueurs dans le jeu.
- **Options Configurables**: Personnalisez le comportement du plugin selon les besoins de votre serveur avec différentes options de configuration.
- **Système de Permissions**: Utilisez les permissions pour contrôler qui peut utiliser la commande de nourriture et qui peut nourrir d'autres joueurs.
- **Option Sans Cooldown**: Choisissez d'imposer un cooldown sur les actions de nourrissage ou de permettre aux joueurs de se nourrir eux-mêmes ou d'autres sans limitation.
- **Messages de Retour**: Informez les joueurs avec des messages informatifs sur le succès ou l'échec de leurs actions de nourrissage.

## Configuration 📝

```yaml
#Configuration pour le plugin FeedCommand

# Messages du Plugin
load-plugin-message: true
load-plugin-message-text: '§aLe plugin FeedCommand a été chargé.'
enable-plugin-message: true
enable-plugin-message-text: '§aLe plugin FeedCommand a été activé.'
unload-plugin-message: true
unload-plugin-message-text: '§cLe plugin FeedCommand a été déchargé.'

# Paramètres de la Commande
name: feed
description: Nourrissez-vous
usage: /feed [joueur]
aliases:
  - eat

# Permissions
permission: feed.command
default: op
permission-feed-others: feed.command.others
default-feed-others: op

# Options Personnalisées
cooldown: -1
cooldown-in-console: false
console-can-feed-other: true
must-pseudo-exact: false
food-restored: 20
saturation-restored: 20

# Messages de Retour
console-cannot-feed-other-message: "§cVous ne pouvez pas nourrir d'autres joueurs depuis la console."
player-not-found-message: '§cJoueur non trouvé.'
feed-message: '§aVous avez été nourri.'
feed-other-message: '§aVous avez nourri %player%.'
feed-by-other-message: '§aVous avez été nourri par %player%.'
cooldown-message: '§cVous devez attendre %time% secondes avant de vous nourrir à nouveau.'
```

## Pour Commencer 🚀

Pour commencer à utiliser FeedCommand sur votre serveur Minecraft, il vous suffit d'installer le plugin et de le configurer selon vos préférences en utilisant les options de configuration fournies. Une fois configuré, les joueurs peuvent utiliser la commande `/feed` pour se nourrir ou aider leurs camarades joueurs.

## Utilisation 🍴

- `/feed [joueur]`: Nourrit le joueur spécifié ou vous-même si aucun joueur n'est spécifié.
- Alias: `/eat`

## Permissions 🛡️

- `feed.command`: Permet l'utilisation de la commande `/feed`.
- `feed.command.others`: Permet de nourrir d'autres joueurs en utilisant la commande `/feed`.

## Support 🤝

Si vous rencontrez des problèmes ou avez des questions concernant FeedCommand, n'hésitez pas à demander de l'aide. Vous pouvez également consulter la documentation pour plus d'informations sur l'utilisation efficace du plugin.

## Licence 📜

FeedCommand est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

Avec FeedCommand, la gestion de la faim devient un jeu d'enfant sur votre serveur Minecraft. Profitez de la commodité de nourrir vous-même et les autres joueurs avec facilité, rendant le gameplay plus agréable pour tous ! 🎮
