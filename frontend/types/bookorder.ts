import type { Year } from "~/types/year"
import type { Book } from "~/types/book"
import type { SchoolClass } from "~/types/schoolclass"

export type BookOrder = {
  id: number
  count: number
  teacherCopy: boolean
  schoolClass: SchoolClass
  bookId: Book
  year: Year
  lastUser: string
  creationUser: string
}
