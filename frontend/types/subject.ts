import type { Book } from "~/types/book"

export type Subject = {
  id: number
  name: string
  books: Book[]
}
