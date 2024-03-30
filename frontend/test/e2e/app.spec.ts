import {test, expect} from "@playwright/test"

test("has title", async ({page}) => {
  await page.goto("/")

  await expect(page).toHaveTitle(/Schulbuchaktion/)
})

test("has spa loading template", async ({page}) => {
  await page.goto("/")

  await page.locator(".loading").isVisible()
})
