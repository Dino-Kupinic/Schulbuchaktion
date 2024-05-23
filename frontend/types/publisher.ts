import type { Book } from "~/types/book"

export type Publisher = {
  id: number
  publisherNumber: number
  name: string
  books: Book[]
}
