export type Category = {
  id: number;
  name: string;
  color: string;
  created_at: string;
  updated_at: string;
  deleted_at: string | null;
};

export type Album = {
  category_id: number;
  category_name: string;
  category_color: string;
  image_url: string;
  created_at: string;
};