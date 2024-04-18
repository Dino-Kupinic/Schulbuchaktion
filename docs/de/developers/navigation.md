# Navigation on this website

Die **NavBar** ist so konzipiert, dass sie als ein **einziger Component** eingebaut wird. Ihre Inhalte (die einzelnen
Menüpunkte) werden in die dafür vorgesehenen Unterkomponenten eingefügt.

Alle Components, die für die Navigation dieser Seite relevant sind, sind im
Ordner `Schulbuchaktion/frontend/components/nav` zu finden.

## Hierarchie der Components

Die hier beschriebene Hierarchie ist von oben nach unten zu lesen (1. ist der oberste Component)

1. **NavBar**: der Hauptcontainer, indem alle anderen Components liegen
2. **NavBarBox**: hier liegen die zwei Components, die für Desktop- und Mobile-Ansicht zuständig sind
3.

- **NavBarDesktop**: die Desktop Ansicht der Navigation.
- **NavBarMobile**: die Mobile Ansicht der Navigation.

4. **NavBarContainer**: der eigentliche Container, den der Nutzer sieht
5. Für **NavBarDesktop:**

   - **NavBarLeftSection**: in diesen Component kommen alle Menüpunkt-Components, die auf der linken Seite der
     Navigationsleiste angezeigt werden sollen z.B.:
     ```html
     <NavBarLeftSection>
       <NavBarLogoLink/>
       <NavUserAvatar/>
       <NavUserDropdown/>
     </NavBarLeftSection>
     ```
   - **NavBarRightSection**: in diesen Component kommen alle Menüpunkt-Components, die auf der rechten Seite der
     Navigationsleiste angezeigt werden sollen


6. Für **NavBarMobile:**
   Hier liegt das **NavBarBurgerMenu**, dieses ist das Menü, das bei Button-Click dargestellt wird.
   Components, die in diesem Menü dargestellt werden sollen, werden hier eingefügt.
   - **NavBarBurgerMenu**: so werden diese Components in das Burger-Menü eingefügt:
   ```html
    <UContainer
    :class="backgroundColor"
    class="absolute top-20 z-10 mr-px flex h-full w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 p-5 opacity-100 dark:border-gray-700"
    >
      <NavUserAvatar />
      <NavUserDropdown />
    </UContainer>
    ```

