export const searchMenus = async () => {
  return await useApiFetch("/api/bc/master/menus");
};
