export const deleteStatus = async (id: number) => {
  const { $showAlert } = useNuxtApp();
  const { data, status, error } = await useApiFetch(
    `/api/bc/master/statuses/${id}`,
    {
      method: "delete",
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
};
