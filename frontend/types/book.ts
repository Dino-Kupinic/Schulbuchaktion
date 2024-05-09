import type { Year } from "~/types/year"
import type { Subject } from "~/types/subject"
import type { Publisher } from "~/types/publisher"

export type Book = {
  id: number
  orderNumber: number
  title: string
  shortTitle?: string
  schoolForm: number
  description?: string
  bookPrice: number
  ebook: boolean
  ebookPlus: boolean
  subject?: Partial<Subject>
  publisher?: Partial<Publisher>
  year: Year[]
  grade: number
}
