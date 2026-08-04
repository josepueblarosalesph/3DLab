"use client";

import { ArrowRight } from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";

const VIDEO_URL =
  "https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260715_090628_7052d8a6-a094-4341-a4a2-ad58493a67a9.mp4";

function BoomerangVideoBg() {
  const videoRef = useRef<HTMLVideoElement>(null);
  const displayCanvasRef = useRef<HTMLCanvasElement>(null);
  const framesRef = useRef<HTMLCanvasElement[]>([]);
  const captureHandleRef = useRef<number | null>(null);
  const lastTimeRef = useRef(-1);
  const [framesReady, setFramesReady] = useState(false);

  const captureFrame = useCallback(() => {
    const video = videoRef.current;
    if (!video || video.ended || video.paused) return;

    if (
      video.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA &&
      video.currentTime !== lastTimeRef.current &&
      video.videoWidth > 0
    ) {
      const width = Math.min(960, video.videoWidth);
      const height = Math.round((video.videoHeight / video.videoWidth) * width);
      const frame = document.createElement("canvas");
      frame.width = width;
      frame.height = height;
      frame.getContext("2d")?.drawImage(video, 0, 0, width, height);
      framesRef.current.push(frame);
      lastTimeRef.current = video.currentTime;
    }

    if ("requestVideoFrameCallback" in video) {
      captureHandleRef.current = video.requestVideoFrameCallback(captureFrame);
    } else {
      captureHandleRef.current = requestAnimationFrame(captureFrame);
    }
  }, []);

  const startCapture = useCallback(() => {
    const video = videoRef.current;
    if (!video || captureHandleRef.current !== null) return;
    if ("requestVideoFrameCallback" in video) {
      captureHandleRef.current = video.requestVideoFrameCallback(captureFrame);
    } else {
      captureHandleRef.current = requestAnimationFrame(captureFrame);
    }
  }, [captureFrame]);

  const stopCapture = useCallback(() => {
    const video = videoRef.current;
    if (captureHandleRef.current === null) return;
    if (video && "cancelVideoFrameCallback" in video) {
      video.cancelVideoFrameCallback(captureHandleRef.current);
    } else {
      cancelAnimationFrame(captureHandleRef.current);
    }
    captureHandleRef.current = null;
  }, []);

  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    const playOnce = () => {
      framesRef.current = [];
      lastTimeRef.current = -1;
      void video.play().then(startCapture).catch(() => {
        // The muted video remains visible if browser autoplay is unavailable.
      });
    };

    const finishCapture = () => {
      stopCapture();
      if (framesRef.current.length > 0) setFramesReady(true);
    };

    video.addEventListener("loadeddata", playOnce, { once: true });
    video.addEventListener("ended", finishCapture);
    if (video.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA) playOnce();

    return () => {
      video.removeEventListener("ended", finishCapture);
      stopCapture();
    };
  }, [startCapture, stopCapture]);

  useEffect(() => {
    if (!framesReady) return;
    const canvas = displayCanvasRef.current;
    const frames = framesRef.current;
    if (!canvas || frames.length === 0) return;

    canvas.width = frames[0].width;
    canvas.height = frames[0].height;
    const context = canvas.getContext("2d");
    if (!context) return;

    let index = 0;
    let direction = 1;
    const draw = () => {
      context.drawImage(frames[index], 0, 0, canvas.width, canvas.height);
      if (frames.length > 1) {
        if (index === frames.length - 1) direction = -1;
        else if (index === 0) direction = 1;
        index += direction;
      }
    };

    draw();
    const interval = window.setInterval(draw, 1000 / 30);
    return () => window.clearInterval(interval);
  }, [framesReady]);

  return (
    <div className="absolute inset-0 z-0 scale-[1.15] origin-top overflow-hidden" aria-hidden="true">
      <video
        ref={videoRef}
        src={VIDEO_URL}
        muted
        playsInline
        preload="auto"
        crossOrigin="anonymous"
        className="h-full w-full object-cover object-top"
        style={{ display: framesReady ? "none" : "block" }}
      />
      <canvas
        ref={displayCanvasRef}
        className="h-full w-full object-cover object-top"
        style={{ display: framesReady ? "block" : "none" }}
      />
    </div>
  );
}

function LogoMark() {
  return (
    <svg viewBox="0 0 256 256" fill="currentColor" className="h-6 w-6 text-[#191919]" aria-hidden="true">
      <path d="M 144 256 L 27.598 256 L 144 139.598 Z" />
      <path d="M 256 207.5 L 200 256 L 200 56 L 0 56 L 48 0 L 256 0 Z" />
      <path d="M 0 204.402 L 0 112 L 92.402 112 Z" />
    </svg>
  );
}

const features = [
  ["01", "Conversational"],
  ["02", "Connected"],
  ["03", "Compliant"],
];

export default function Home() {
  return (
    <main className="min-h-screen overflow-x-hidden bg-white text-[#191919]">
      <nav className="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-4 sm:px-10 sm:py-5 md:px-14">
        <a href="#" className="flex items-center gap-2.5" aria-label="Boomerang home">
          <LogoMark />
          <span className="text-base font-semibold tracking-tight text-[#191919]">Boomerang</span>
        </a>

        <div className="absolute left-1/2 hidden -translate-x-1/2 items-center gap-8 md:flex">
          {[
            ["Product", "#product"],
            ["Solutions", "#solutions"],
            ["Pricing", "#pricing"],
            ["Company", "#company"],
          ].map(([label, href]) => (
            <a key={label} href={href} className="text-sm text-[#191919]/70 transition-colors duration-200 hover:text-[#191919]">
              {label}
            </a>
          ))}
        </div>

        <a href="#demo" className="rounded-lg bg-[#191919] px-5 py-2.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-[#191919]/90">
          Book A Demo
        </a>
      </nav>

      <section className="relative flex h-screen flex-col items-center overflow-hidden">
        <BoomerangVideoBg />

        <div className="relative z-10 flex flex-col items-center px-4 pt-24 text-center sm:px-6 sm:pt-26 md:pt-32">
          <h1 className="font-serif text-4xl leading-[1.1] font-normal tracking-tighter text-[#191919] sm:text-5xl md:text-7xl lg:text-8xl">
            Build lasting
            <br />
            relationships.
          </h1>
          <p className="mt-5 max-w-sm text-sm leading-relaxed text-[#191919]/70 sm:mt-6 sm:max-w-md md:mt-8 md:text-base">
            Conversational AI platform for modern financial institutions — agents that handle the full borrower lifecycle across email, SMS, and voice.
          </p>
          <a id="demo" href="mailto:hello@boomerang.ai" className="mt-6 rounded-lg bg-[#191919] px-6 py-3 text-sm font-medium text-white transition-colors duration-200 hover:bg-[#191919]/90 sm:mt-8 sm:px-8 sm:py-3.5 md:mt-10">
            Book A Demo
          </a>
        </div>

        <div id="product" className="relative z-10 mt-auto w-full max-w-5xl px-4 sm:px-6">
          <div className="border border-b-0 border-gray-200 bg-white/90 px-5 pt-8 pb-0 shadow-sm backdrop-blur-sm sm:px-8 sm:pt-12 md:px-12 md:pt-16">
            <div className="grid gap-6 md:grid-cols-2 md:gap-16">
              <div>
                <p className="text-[11px] font-medium tracking-[0.2em] text-[#191919]/50 uppercase">What do we do?</p>
                <h2 className="mt-3 font-serif text-2xl leading-tight font-normal tracking-tight sm:text-3xl md:text-4xl">
                  Conversations that <br className="hidden sm:block" /> build momentum
                </h2>
              </div>
              <p className="self-end text-sm leading-relaxed text-[#191919]/70 md:text-[15px]">
                Conversational AI built for regulated financial institutions. Agents that hold a real conversation, plug into the systems you run, and show their work.
              </p>
            </div>

            <div className="mt-6 h-px w-full bg-gray-200 sm:mt-8 md:mt-10" />

            <div className="grid gap-2 sm:grid-cols-3 sm:gap-3">
              {features.map(([number, label]) => (
                <button key={number} type="button" className="group flex cursor-pointer items-center justify-between bg-[#F4F3F3] px-4 py-3.5 text-left text-sm transition-all duration-200 hover:bg-[#eaeaea] sm:px-6 sm:py-4">
                  <span>
                    <span className="text-[#191919]/40">{number}</span>
                    <span className="mx-2 text-[#191919]/30">/</span>
                    <span className="font-medium">{label}</span>
                  </span>
                  <ArrowRight className="h-4 w-4 text-gray-400 transition-all duration-200 group-hover:translate-x-0.5 group-hover:text-gray-700" />
                </button>
              ))}
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}
