import Link from 'next/link';

export default function Home() {
    return (
        <div class="group not-prose relative overflow-hidden sm:overflow-visible">
            <div class="p-8 @container relative overflow-auto rounded-lg outline outline-white/5 dark:bg-gray-950/50 dark:inset-ring dark:inset-ring-white/5 group-data-dragging:before:absolute group-data-dragging:before:inset-0">
                <div class="mx-auto max-w-xl space-y-2 rounded-xl bg-white px-8 py-8 shadow-lg ring ring-black/5 @sm:flex @sm:items-center @sm:space-y-0 @sm:gap-x-6 @sm:py-4">
                    <div class="space-y-2 text-center @sm:text-left">
                        <div class="space-y-0.5">
                            <p className="text-m font-semibold text-black">Bienvenue sur la page d'accueil</p>
                            <p className="text-xs">Ceci est un exercice NextJS - Laravel</p>
                            <p className="text-xs">Vous devrez mettre en place les exercices listés dans le README.md de la racine du répo.</p>
                        </div>

                        <Link href="/client" className="cursor-pointer rounded-full border border-purple-200 px-4 py-1 text-sm font-semibold text-purple-600 hover:border-transparent hover:bg-purple-600 hover:text-white active:bg-purple-700">Client area</Link>
                        <Link href="/admin" className="mx-2 cursor-pointer rounded-full border border-purple-200 px-4 py-1 text-sm font-semibold text-purple-600 hover:border-transparent hover:bg-purple-600 hover:text-white active:bg-purple-700">Admin area</Link>
                        <Link href="/products" className="cursor-pointer rounded-full border border-purple-200 px-4 py-1 text-sm font-semibold text-purple-600 hover:border-transparent hover:bg-purple-600 hover:text-white active:bg-purple-700">Start shopping</Link>
                    </div>
                </div>
            </div>
        </div>
    )
}
