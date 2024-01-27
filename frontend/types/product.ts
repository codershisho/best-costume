export type Product = {
  id: number;
  scrape_site_id: number;
  name: string;
  category_id: number;
  price: number;
  thumbnail: string;
  favorite: boolean;
  site: string;
  menu: string;
  updated_at: string;
};

export type ProductRegist = {
  id: number;
  scrape_site_id: number;
  name: string | null;
  category_id: number | null;
  price: number | null;
  description: string | null;
  images: Array<File> | null;
};

export type ProductDetail = {
  id: number;
  scrape_site_id: number;
  name: string;
  category_id: number;
  category_name: string;
  price: number;
  description: string;
  images: string[];
};

export type Order = {
  order_id: number;
  customer_id: number;
  customer_name: string;
  customer_phone: string;
  product_id: number;
  product_name: string;
  product_price: number;
  product_url: string;
  status_id: number;
  status_name: string;
  status_color: string;
  created_at: string;
  updated_at: string;
};
