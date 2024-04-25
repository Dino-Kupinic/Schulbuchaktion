# Navigation

Alle relevanten Komponenten sind in `/frontend/components/nav` zu finden.

## Hierarchie

1. **NavBar**: Hauptcontainer, in dem sich alle anderen Komponenten befinden
2. **NavBarBox**: die beiden Komponenten, die für die Desktop- und die mobile Ansicht zuständig sind
3. **NavBarDesktop** und **NavBarMobile**
4. **NavBarContainer**
5. **NavBarDesktop:**

- **NavBarLeftSection**: Diese Komponente enthält alle Menüpunktkomponenten, die auf der linken Seite der
  Navigationsleiste angezeigt werden sollen, z.B:
  ```html
  <NavBarLeftSection>
    <NavBarLogoLink/>
    <NavUserAvatar/>
    <NavUserDropdown/>
  </NavBarLeftSection>
  ```
- **NavBarRightSection**: Diese Komponente enthält alle Menüpunktkomponenten, die auf der rechten Seite der
  Navigationsleiste angezeigt werden sollen.

6. **NavBarMobile:**
   Hier ist das **NavBarBurgerMenu**, das ist das Menü, das angezeigt wird, wenn die Schaltfläche angeklickt wird.
   Die Komponenten, die in diesem Menü angezeigt werden sollen, werden hier eingefügt.

- **NavBarBurgerMenu**: So werden diese Komponenten in das Burger-Menü eingefügt:
   ```html
    <UContainer
    :class="backgroundColor"
    class="absolute top-20 z-10 mr-px flex h-full w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 p-5 opacity-100 dark:border-gray-700"
    >
      <NavUserAvatar />
      <NavUserDropdown />
    </UContainer>
   ```
