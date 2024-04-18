# Navigation on this website

The **NavBar** is designed to be integrated as a **single component**. Its contents (the individual
menu items) are inserted into the sub-components provided for this purpose.

All components that are relevant for the navigation of this page are stored in the
folder `Schulbuchaktion/frontend/components/nav`.

## Hierarchy of the components

The hierarchy described here is to be read from top to bottom (1. is the topmost component)

1. **NavBar**: the main container in which all other components are located
2. **NavBarBox**: here are the two components responsible for desktop and mobile view
3.

- NavBarDesktop**: the desktop view of the navigation.
- NavBarMobile**: the mobile view of the navigation.

4. **NavBarContainer**: the actual container that the user sees
5. for **NavBarDesktop:**

  - **NavBarLeftSection**: this component contains all menu item components that are to be displayed on the left-hand side of the
    navigation bar, e.g:
    ```html
    <NavBarLeftSection>
      <NavBarLogoLink/>
      <NavUserAvatar/>
      <NavUserDropdown/>
    </NavBarLeftSection>
    ```
  - **NavBarRightSection**: this component contains all menu item components that are to be displayed on the right side of the
    navigation bar should be displayed

6. for **NavBarMobile:**
   Here is the **NavBarBurgerMenu**, this is the menu that is displayed when the button is clicked.
   Components that are to be displayed in this menu are inserted here.
  - **NavBarBurgerMenu**: this is how these components are inserted into the burger menu:
   ```html
    <UContainer
    :class="backgroundColor"
    class="absolute top-20 z-10 mr-px flex h-full w-[97%] flex-col items-start justify-start gap-y-5 overflow-x-hidden rounded-b border border-t-0 border-neutral-300 p-5 opacity-100 dark:border-gray-700"
    >
      <NavUserAvatar />
      <NavUserDropdown />
    </UContainer>
    ```
