export const searchScrapeSite = async () => {
  return await useApiFetch("api/bc/admin/scrape/sites");
};

export const execScrape = async (siteId: number, url: string) => {
  const { $showAlert } = useNuxtApp();
  const res = await useApiFetch("/api/bc/admin/scrape", {
    method: "post",
    body: {
      site_id: siteId,
      url: url,
    },
  });

  if (res.status.value == "success") {
    const message = res.data.value.message;
    $showAlert("success", "成功", message);
    return res.data;
  }

  if (res.status.value == "error") {
    const errMessage = res.error.value.data.message;
    $showAlert("error", "スクレイピングに失敗", errMessage);
  }
};
