module.exports = {
  apps: [
    {
      name: "best-costume",
      exec_mode: "cluster",
      instances: "max",
      script: "./.output/server/index.mjs",
    },
  ],
};
