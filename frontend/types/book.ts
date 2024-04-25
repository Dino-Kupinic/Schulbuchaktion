type Book = {
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
  year: Years[]
  grade: number
}
