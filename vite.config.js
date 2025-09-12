// import { createAppConfig } from "@nextcloud/vite-config";
// import { join, resolve } from "path";

// export default createAppConfig({
//     dashboardTalk: resolve(join("src", "dashboardTalk.js")),
// })
import { createAppConfig } from "@nextcloud/vite-config"
import { join, resolve } from "path"
import eslint from "vite-plugin-eslint"
import stylelint from "vite-plugin-stylelint"

const isProduction = process.env.NODE_ENV === "production"

export default createAppConfig(
  {
    dashboardTalk: resolve(join("src", "dashboardTalk.js")),
  },
  {
    config: {
      css: {
        modules: {
          localsConvention: "camelCase",
        },
      },
      plugins: [eslint(), stylelint()],
    },
    inlineCSS: { relativeCSSInjection: true },
    minify: isProduction,
    createEmptyCSSEntryPoints: true,
    extractLicenseInformation: true,
    thirdPartyLicense: false,
  }
)
eslint({
  failOnError: false
})
