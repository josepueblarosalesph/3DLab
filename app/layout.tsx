import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  metadataBase: new URL("https://boomerang.openai.site"),
  title: "Build Lasting Relationships",
  description: "Boomerang conversational AI for modern financial institutions.",
  icons: { icon: "/favicon.svg", shortcut: "/favicon.svg" },
  openGraph: {
    title: "Build Lasting Relationships",
    description: "Boomerang conversational AI for modern financial institutions.",
    images: [{ url: "/og.png", width: 1200, height: 630, alt: "Boomerang — Build lasting relationships." }],
  },
  twitter: {
    card: "summary_large_image",
    title: "Build Lasting Relationships",
    description: "Boomerang conversational AI for modern financial institutions.",
    images: ["/og.png"],
  },
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="en">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link rel="stylesheet" href="https://db.onlinewebfonts.com/c/9d4d074c9335825a23cce178ee03b498?family=P22+Mackinac+W01+Book" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" />
      </head>
      <body>{children}</body>
    </html>
  );
}
