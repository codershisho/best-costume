export const fetchAlbums = async (categoryId: number, page: number = 1) => {
  const params = {};
  if (categoryId != null && categoryId != 0 && categoryId != undefined && !isNaN(categoryId)) {
    params.category_id = categoryId;
  }
  return await useApiFetch(
    `/api/bc/admin/albums/uploaded?page=${page}`,
    {
      method: "get",
      params: params,
    }
  );
}

export const fetchCategory = async () => {
  return await useApiFetch("/api/bc/master/categories");
}

export const deleteAlbums = async (ids: Array<number>) => {
  const { $showAlert } = useNuxtApp();
  const { data, status, error } = await useApiFetch("/api/bc/admin/albums/uploaded",
    {
      method: 'delete',
      body: {
        ids: ids
      }
    }
  );

  if (status.value == "success") {
    $showAlert("success", "成功", data.value.message);
    return;
  }

  if (status.value == "error") {
    const errMessage = error.value.data.message;
    $showAlert("error", "失敗", errMessage);
  }
}