# FeedCommand Plugin 🍲

FeedCommand for Minecraft servers lets players feed themselves or others with a simple command.

## Features 🛠️

- **Command**: Use `/feed` to feed yourself or others.
- **Configurable**: Various customization options.
- **Permissions**: Control command access.
- **Cooldown**: Optional cooldown for feeding.
- **Messages**: Inform players of actions.

## Configuration 📝

```yaml
# FeedCommand Configuration

# Plugin Messages
load-plugin-message: true
load-plugin-message-text: '§aFeedCommand loaded.'
enable-plugin-message: true
enable-plugin-message-text: '§aFeedCommand enabled.'
unload-plugin-message: true
unload-plugin-message-text: '§cFeedCommand unloaded.'

# Command Settings
name: feed
description: Feed yourself
usage: /feed [player]
aliases:
  - eat

# Permissions
permission: feed.command
default: op
permission-feed-others: feed.command.others
default-feed-others: op

# Options
cooldown: -1
food-restored: 20
saturation-restored: 20

# Messages
console-cannot-feed-other-message: "§cCannot feed others from console."
player-not-found-message: '§cPlayer not found.'
feed-message: '§aYou have been fed.'
feed-other-message: '§aYou fed %player%.'
feed-by-other-message: '§aYou were fed by %player%.'
cooldown-message: '§cWait %time% seconds to feed again.'

## Usage 🍴

- `/feed [player]`: Feed yourself or another player.
- Alias: `/eat`

## Permissions 🛡️

- `feed.command`: Use `/feed`.
- `feed.command.others`: Feed others.
```

## License 📜

Licensed under MIT. See [LICENSE](LICENSE) for details.

---

Simplify hunger management on your Minecraft server with FeedCommand! 🎮
