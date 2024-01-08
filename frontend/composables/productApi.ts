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
};

export const fetchProducts = async (
  text: string = "",
  page: number = 0
): Promise<productTypes.Product[]> => {

  const params = {};

  if (text != '') {
    params.searchText = text;
  }

  const { data, status, error } = await useApiFetch(
    `api/bc/master/products/search?page=${page}`,
    {
      method: 'get',
      params: params
    }
  );
  return data.value as productTypes.Product[];
};

export const deleteProducts = async (ids: Array<number>) => {
  const { $showAlert } = useNuxtApp();
  const { data, status, error } = await useApiFetch('api/bc/master/products', {
    method: 'delete',
    body: {
      ids: ids
    }
  })

  if (status.value == "success") {
    $showAlert("success", "成功", data.value.message);
    return;
  }

  if (status.value == "error") {
    const errMessage = error.value.data.message;
    $showAlert("error", "失敗", errMessage);
  }
}
