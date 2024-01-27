export const deleteCategory = async (id: number) => {
  await useApiFetch(`/api/bc/master/categories/${id}`, {
    method: "delete",
  });
};
