# Navigation

All components that are relevant can be found in `/frontend/components/nav`.

## Hierarchy

1. **NavBar**: main container in which all other components are located
2. **NavBarBox**: the two components responsible for desktop and mobile view
3. **NavBarDesktop** and **NavBarMobile**
4. **NavBarContainer**
5. **NavBarDesktop:**

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

6. **NavBarMobile:**
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
