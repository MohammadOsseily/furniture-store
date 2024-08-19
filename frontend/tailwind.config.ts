import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  plugins: [
    require("@tailwindcss/typography"),
    require("daisyui"),
    require("tailwind-scrollbar"),
  ],
  daisyui: {
    themes: [
      {
        mytheme: {
          primary: "#F9F7F7",
          secondary: "#383838",
          accent: "#B2F042",
          neutral: "#C9CCD1",
          "base-100": "#F9F5F6",
          info: "#3abff8",
          success: "#36d399",
          warning: "#fbbd23",
          error: "#f87272",
          "base-200": "#D83776",
          "base-300": "#3B5998",
        },
      },
    ],
  },
};

export default config;
