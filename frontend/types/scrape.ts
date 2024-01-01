export type Site = {
  id: number,
  name: string
}

export type ScrapeResult = {
  id: number;
  site_id: number;
  url: string;
  title: string;
  description: string;
  price: string;
  images: string;
  note: null | string;
  created_at: string;
  updated_at: string;
  deleted_at: null | string;
};