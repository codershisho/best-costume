import * as productTypes from "../types/product";

export const registProduct = async (model: productTypes.ProductRegist) => {
  await useApiFetch("/api/bc/master/products", {
    method: "post",
    body: model,
  });
};

export const fetchProducts = async (
  text: string = "",
  page: number = 0,
  id: number = 0
): Promise<productTypes.Product[]> => {
  const params = {};

  if (text != "") {
    params.searchText = text;
  }

  if (id != 0) {
    params.category = id;
  }

  return await useApiFetch(`/api/bc/master/products/search?page=${page}`, {
    method: "get",
    params: params,
  });
};

export const deleteProducts = async (ids: Array<number>) => {
  await useApiFetch("/api/bc/master/products", {
    method: "delete",
    body: {
      ids: ids,
    },
  });
};
