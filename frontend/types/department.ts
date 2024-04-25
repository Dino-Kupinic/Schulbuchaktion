type Department = {
  id: number
  name: string
  budget: number
  usedBudget: number
  schoolClasses: SchoolClass[]
  validFrom?: Date
  validTo?: Date
}
