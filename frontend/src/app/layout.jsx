import './globals.css'
import { adminAuth } from "App/lib/auth-admin"
import { clientAuth } from "App/lib/auth-client"
import Providers from './Providers';
export default async function RootLayout({ children }) {
  const sessionAdmin = await adminAuth()
  const sessionClient = await clientAuth()
  return (
    <html className="h-full bg-gray-900" lang="fr">
      <body className="h-full">
        <Providers session={sessionAdmin || sessionClient}>
          <div className="max-w-screen overflow-x-hidden">
            {children}
          </div>
        </Providers>
      </body>
    </html>
  )
}
