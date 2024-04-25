# Navbar User

Der `NavUser` ist in der oberen linken Ecke
der Navigationsleiste.

Sie enthält vier Schaltflächen. Eine Schaltfläche für den Zugang
zu allen Lehrern `Alle Lehrer`, eine Schaltfläche für den Zugriff
auf die Bücher,
die ein Benutzer ausgeliehen hat, `Meine Bücher`.

Neben einer Schaltfläche, um zu Ihrem Profil zu gelangen, gibt es auch eine Schaltfläche zum
Abmelden" von Ihrem Konto.

Die Dropdown-Liste `<NavUserDropdown />`, die beim Anklicken des `<NavUserAvatar />` erscheint
wird wie folgt implementiert:

- Elemente des Dropdowns

```js
const items = [
  [
    {
      label: "Dino Kupinic",
      link: "#",
      slot: "Konto"
    }
  ]
]
```

 - Die Liste selbst

Für das Dropdown wird die Nuxt-Komponente `<UDropdown />` verwendet.

