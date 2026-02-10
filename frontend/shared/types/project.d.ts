export type Access = "Public" | "Private"

export interface Project {
  id: number;
  title: string;
  client: string;
  is_tracked: boolean;
  progress: number;
  access: Access;
};
