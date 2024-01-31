export const deleteStatus = async (id: number) => {
  await useApiFetch(`/api/bc/master/statuses/${id}`, {
    method: "delete",
  });
};
