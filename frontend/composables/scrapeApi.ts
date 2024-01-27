export const searchScrapeSite = async () => {
  return await useApiFetch("/api/bc/admin/scrape/sites");
};

export const execScrape = async (siteId: number, url: string) => {
  await useApiFetch("/api/bc/admin/scrape", {
    method: "post",
    body: {
      site_id: siteId,
      url: url,
    },
  });
};
