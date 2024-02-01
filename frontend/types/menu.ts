export type Menu = {
  id: Number;
  name: String;
  children: Array<MenuDetail>;
};

export type MenuDetail = {
  id: number;
  name: string;
  count: number;
};
