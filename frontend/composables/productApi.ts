import * as productTypes from "../types/product";

export const registProduct = async (model: productTypes.ProductRegist) => {
  const { $showAlert } = useNuxtApp();
  const { data, status, error } = await useApiFetch("api/bc/master/products", {
    method: "post",
    body: model,
  });

  if (status.value == "success") {
    $showAlert("success", "成功", data.value.message);
    return;
  }

  if (status.value == "error") {
    const errMessage = error.value.data.message;
    $showAlert("error", "失敗", errMessage);
  }
}