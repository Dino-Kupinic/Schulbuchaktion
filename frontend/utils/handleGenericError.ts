/**
 * Handle generic error
 * @param err The error object
 * @param title The title of the error notification
 * @param description The description of the error notification
 */
export default function (err: unknown, title?: string, description?: string) {
  const error = err as Error

  const { t } = useI18n()

  const notificationTitle: string = title ?? t("error.generic.title")
  const notificationDescription: string =
    description ?? t("error.generic.description")

  displayFailureNotification(notificationTitle, notificationDescription)

  throw createError({
    statusMessage: error.message,
  })
}
